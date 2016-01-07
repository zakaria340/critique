<?php
/*
Plugin Name: Delete Duplicate Posts
Plugin Script: delete-duplicate-posts.php
Plugin URI: http://cleverplugins.com
Description: Get rid of duplicate blogposts on your blog! Searches and removes duplicate posts and their post meta tags.
Version: 3.1
Author: cleverplugins.com
Author URI: http://cleverplugins.com
Min WP Version: 3.6
Max WP Version: 4.0

== Changelog ==

= 3.1 = 
* Fix for deleting any dupes but posts - ie. not menu items :-/
* Fix for PHP warnings.
* Fix for old user capabilities code.

= 3.0 = 
* Code refactoring and updates - Basically rewrote most of the plugin.
* Removed link in footer.
* Removed dashboard widget.
* Internationalization - Now plugin can be translated
* Danish language file added.

= 2.1 =
* Bugfixes

= 2.0.6 =
* Bugfix: Problem with the link-donation logic. Hereby fixed. 

= 2.0.5 =
* Bugfix: Could not access the settings page from the Plugins page. 
* Ads are no longer optional. Sorry about that :-)
* Changes to the amount of duplicates you can delete using CRON.


= 2.0.4 =
* Bugfix : A minor speed improvement.

= 2.0.3 =
* Bugfix : Minor logic error fixed.

= 2.0.2 =
* Bugfix : Now actually deletes duplicate posts when clicking the button manually.. Doh...


= 2.0 =
* Design interface updated
+ New automatic CRON feature as per many user requests
+ Optional: E-mail notifications


= 1.3.1 =
* Fixes problem with dashboard widget. Thanks to Derek for pinpointing the error.

= 1.3 =
* Ensures all post meta for the deleted blogposts are also removed...

= 1.1 =
* Uses internal delete function, which also cleans up leftover meta-data. Takes a lot more time to complete however and might time out on some hosts.

= 1.0 =
* First release

*/


if (!class_exists('delete_duplicate_posts')) {
	class delete_duplicate_posts {
		var $optionsName = 'delete_duplicate_posts_options';
		var $localizationDomain = "delete_duplicate_posts";
	//	var $thispluginurl = '';
	//	var $thispluginpath = '';
		var $options = array();
	//	function delete_duplicate_posts(){$this->__construct();}
		function __construct(){
			$locale = get_locale();
			$mo = dirname(__FILE__) . "/languages/" . 'delete_duplicate_posts' . "-".$locale.".mo";
		//	load_plugin_textdomain('delete_duplicate_posts', $mo);
			load_plugin_textdomain( 'delete_duplicate_posts', FALSE,  dirname( __FILE__ )  . '/languages/' );
			//"Constants" setup
			//$this->thispluginurl = PLUGIN_URL . '/' . dirname(plugin_basename(__FILE__)).'/';
		//	$this->thispluginpath = PLUGIN_PATH . '/' . dirname(plugin_basename(__FILE__)).'/';


			$this->getOptions();
	  // Setting filters, actions, hooks....      
			add_action("admin_menu", array(&$this,"admin_menu_link"));

			register_activation_hook(__FILE__,array(&$this,"install"));
			add_action('admin_head', array(&$this,"admin_register_head"));
		//	add_action('init', array(&$this,"init_function"));
			add_action('ddp_cron', array(&$this,"cleandupes"));
			add_filter('cron_schedules', array(&$this, "filter_cron_schedules"));
			//add_action('load_ads', array(&$this,"cron_load_ads"));
			
		}

	function init_function() {
	//		load_plugin_textdomain('delete_duplicate_posts', false, dirname(plugin_basename(__FILE__)) . '/languages');
		}



		function cleandupes($manualrun='0') {
			$this->getOptions();
			if (!$this->options['ddp_running'] ) {
				$this->options['ddp_running']=TRUE;
				global $wpdb;
				$table_name = $wpdb->prefix . "posts";	
				$limit=$this->options['ddp_limit'];
				if (!$limit<>'') $limit=10; //defaults to 10!			
				if ($manualrun=='1') $limit=9999;
				$order=$this->options['ddp_keep'];
				if (($order<>'oldest') OR ($order<>'latest')) { // verify default value has been set.
					$this->options['ddp_keep']='oldest';
				}
				if ($order=='oldest') $minmax="MIN(id)";
				if ($order=='latest') $minmax="MAX(id)";
		
				$query="select bad_rows.*
				from $table_name as bad_rows
				inner join (
					select post_title,id, $minmax as min_id
					from $table_name 
					WHERE (
						`post_status` = 'publish'
						AND
						`post_type` = 'post'
						)
					group by post_title
					having count(*) > 1
					) as good_rows on good_rows.post_title = bad_rows.post_title
					and good_rows.min_id <> bad_rows.id
					and (bad_rows.post_status='publish' OR bad_rows.post_status='draft')
					limit $limit;
					";

				$dupes = $wpdb->get_results($query);
				$dupescount = count($dupes); 
				$resultnote='';
				$dispcount=0;
				
				foreach ($dupes as $dupe) {
					$postid=$dupe->ID;
					$title=substr($dupe->post_title,0,35);
					$perma=get_permalink($postid);
					if ($postid<>''){
						$custom_field_keys = get_post_custom_keys($postid);
						foreach ( $custom_field_keys as $key => $value ) {
							delete_post_meta($postid, $key, '');

						}
						$result = wp_delete_post($postid);
						if (!$result) {	
							$this->log(sprintf( __( "Error, problem deleting post '%d' %s", 'delete_duplicate_posts'), $postid,$perma));	
						}
						else {	
							$dispcount++;
							$this->log(sprintf( __( "Deleted post '%s' (id: %s) and related post meta data.", 'delete_duplicate_posts'), $title, $postid ));
						}
					}
				} // foreach ($dupes as $dupe)			

				if ($dispcount>0) {
					$this->log(sprintf( __( "A total of %s duplicate posts were deleted.", 'delete_duplicate_posts'), $dispcount));

				}

					// Mail logic...	
				if (($dispcount>0) &&($manualrun=='1') && ($this->options['ddp_statusmail'])) { 

					$adminemail = get_option('admin_email'); // get admins email

					$blogurl = home_url();

					$messagebody = sprintf( __( "Hi Admin, I have deleted <strong>%d</strong> Duplicate Blog posts automatically on your blog, %s.<br><br><em>You are receiving this e-mail because you have turned on e-mail notifications by the plugin, Delete Duplicate Posts.</em>",'delete_duplicate_posts'), $dispcount, $blogurl);
					
					$headers = "From: $blogurl <$adminemail>" . "\r\n\\";

					$mailstatus = wp_mail($adminemail, __('Deleted Duplicate Posts Status','delete_duplicate_posts'), $messagebody, $headers);		

					if ($mailstatus) {
						$this->log(sprintf( __( "Status email sent to %s.", 'delete_duplicate_posts'), $adminemail));
					}
				}

				$this->options['ddp_running']=FALSE;
			}
		}


		function admin_register_head() {

		}



		function log($text) {
			global $wpdb;
			$ddp_logtable = $wpdb->prefix . "delete-duplicate-posts_log";
			$time= current_time("mysql");
			$text= mysql_real_escape_string($text);
			$daquery="INSERT INTO `$ddp_logtable` (time,note) VALUES ('$time','$text');"; //todo - set up with $wpdb->prepare()
			$result=$wpdb->query($daquery);
			$total = (int) $wpdb->get_var("SELECT COUNT(*) FROM `$ddp_logtable`;");
			if ($total>1000) {
				$targettime = $wpdb->get_var("SELECT `time` from `$ddp_logtable` order by `time` DESC limit 500,1;");
				$query="DELETE from `$ddp_logtable`  where `time` < '$targettime';";
				$success= $wpdb->query ($query);
			}
		}




		function install () {
			global $wpdb;
			require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

			$table_name = $wpdb->prefix . "woocommerce_arr_log";
			if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
				$sql = "CREATE TABLE $table_name (
					id bigint(20) NOT NULL AUTO_INCREMENT,
					time timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
					prio tinyint(1) NOT NULL,
					note tinytext NOT NULL,
					PRIMARY KEY (id)
					);";
				dbDelta($sql);
			}   
			$this->saveAdminOptions();
			wp_clear_scheduled_hook('ddp_cron');
			$this->log(__( "Plugin activated.", 'delete_duplicate_posts'));
		}	


		function getOptions() {
			//Don't forget to set up the default options
			if (!$theOptions = get_option($this->optionsName)) {
				$theOptions = array('default'=>'options');
				update_option($this->optionsName, $theOptions);
			}
			$this->options = $theOptions;

		}
		
		function saveAdminOptions(){
			return update_option($this->optionsName, $this->options);
		}
		


		function admin_menu_link() {
			add_management_page('Delete Duplicate Posts', 'Delete Duplicate Posts', 'manage_options', basename(__FILE__), array(&$this,'admin_options_page'));
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'filter_plugin_actions'), 10, 2 ); // Adds the Settings link to the plugin page
		}


		function filter_plugin_actions($links, $file) {
			$settings_link = '<a href="tools.php?page=' . basename(__FILE__) . '">' . __('Settings','delete_duplicate_posts') . '</a>';
		   array_unshift( $links, $settings_link ); // before other links
		   return $links;
		}


		function filter_cron_schedules( $param ) {
			return array( '30min' => array( 
				'interval' => 1800, 
				'display'  => __( 'Every 30 minutes','delete_duplicate_posts' ) 
				) 

			);
		}




		function admin_options_page() { 


		// DELETE NOW
		if ( (isset($_POST['deleteduplicateposts_delete'] ) ) AND (isset($_POST['_wpnonce'] ) ) )  {
				if  (wp_verify_nonce($_POST['_wpnonce'], 'ddp-clean-now')){
				$this->cleandupes(1); // use the value 1 to indicate it is being run manually.
			}
		}
	
		// RUN NOW!!
			if(isset($_POST['ddp_runnow'])){
				if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp-update-options') ) die(__('Whoops! Some error occured, try again, please!','delete_duplicate_posts')); 

				if ( function_exists('current_user_can') && current_user_can('edit_plugins')) {
					$search4dupes=true; // remember that we are searching for dupes! .. is used later on in this function as to not disturb the layout
				}
			}



		// SAVING OPTIONS
			if  (isset($_POST['delete_duplicate_posts_save'])){
				if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp-update-options') ) 
					die(__('Whoops! There was a problem with the data you posted. Please go back and try again.','delete_duplicate_posts'));

				$this->options['ddp_enabled'] = ($_POST['ddp_enabled']=='on')?true:false;
				$this->options['ddp_statusmail'] = ($_POST['ddp_statusmail']=='on')?true:false;
				$this->options['ddp_keep'] = mysql_real_escape_string($_POST['ddp_keep']);
				
				$this->options['ddp_limit'] = $_POST['ddp_limit'];

				if (isset($this->options['ddp_enabled'])) {
					wp_clear_scheduled_hook('ddp_cron');
					wp_schedule_event(time()+$this->options['ddp_postinterval'], '30min', 'ddp_cron');
				}
				
				$this->saveAdminOptions();
				
				echo '<div class="updated fade"><p>'.__('Your changes were successfully saved.','delete_duplicate_posts').'</p></div>';
			}

		// CLEARING THE LOG
			if(isset($_POST['ddp_clearlog'])) {
				if (! wp_verify_nonce($_POST['_wpnonce'], 'ddp_clearlog_nonce') ) die(__('Whoops! Some error occured, try again, please!','delete_duplicate_posts')); 
				global $wpdb;
				$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";	
				$wpdb->query ("TRUNCATE `$table_name_log`;");
				echo '<div class="updated"><p>'.__('The log was cleared.','delete_duplicate_posts').'</p></div>';
				unset($wpdb);
			}			


			global $wpdb;
	

			// $table_name = $wpdb->prefix . "delete-duplicate-posts_log";    
			// if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
			// 	$this->install();
			// }
	
			$table_name = $wpdb->prefix . "posts";	

			$pluginfo=get_plugin_data(__FILE__);
			$version=$pluginfo['Version'];	
			$name=$pluginfo['Name'];
			?>

			<div class="wrap">    
				<div style="float:right;">
					<a href="http://cleverplugins.com" target="_blank"><img src='<?php echo plugin_dir_url(__FILE__); ?>/cleverpluginslogo.png'></a>
				</div>
				<h2>Delete Duplicate Posts v <?php echo $version; ?></h2>
				<p><?php _e('This plugin can delete duplicate posts on your site for you. Run this plugin at your own risk, and we recommend you always make a backup before running this tool.','delete_duplicate_posts');?></p>
		
				<div id="dashboard">
					<?php
					if ($this->options['ddp_enabled'] ) {
						$nextscheduled = wp_next_scheduled('ddp_cron');
						if (!$nextscheduled<>'') { // plugin active, but the cron needs to be activated also..
							wp_clear_scheduled_hook('ddp_cron');
							wp_schedule_event(time()+$this->options['ddp_postinterval'], '30min', 'ddp_cron');
							$nextscheduled = wp_next_scheduled('ddp_cron');
						}
					}
					else {
						wp_clear_scheduled_hook('ddp_cron');
					}

					$query="select bad_rows.ID, bad_rows.post_title
					from $table_name as bad_rows
					inner join (
						select post_title,id, MIN(id) as min_id
						from $table_name 
						WHERE (
							`post_status` = 'publish'
							AND
							`post_type` = 'post'
						)
						group by post_title
						having count(*) > 1
						) as good_rows on good_rows.post_title = bad_rows.post_title
						and good_rows.min_id <> bad_rows.id
						and (bad_rows.post_status='publish' OR bad_rows.post_status='draft')
						order by post_title,id
						;
						";


					$dupes = $wpdb->get_results($query);
					$dupescount = count($dupes); 	

					if ($dupescount) {

						?>
						<div> 
							<p><?php
								echo sprintf( __('I have discovered %d duplicate blogposts', 'delete_duplicate_posts'), $dupescount); ?></p>
							<?php
							$plugurl=WP_CONTENT_URL . '/plugins/' .plugin_basename(__FILE__) ;	
							?>
							<table class="widefat post" cellspacing="0">
								<thead>
									<tr>
										<th><?php _e('ID','delete_duplicate_posts'); ?></th><th><?php _e('Title','delete_duplicate_posts'); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($dupes as $dupe) {
										$postid=$dupe->ID;
										$title=substr($dupe->post_title,0,120);
										echo "<tr><td>".$postid."</td><td><a href='".get_permalink($postid)."' target='_blank'>".$title."</a></td></tr>";
									}
								?>
								</tbody>
							</table>
						
							<form method="post" id="ddp_runcleannow">
								<?php wp_nonce_field('ddp-clean-now'); ?>
								<p align="center"><input type="submit" name="deleteduplicateposts_delete" class="button-primary" value="<?php _e('Delete all duplicates','delete_duplicate_posts'); ?>" /></p>
							</form>
						</div>
						<hr>
						<?php
					} // if ($dupescount)

				else { // no dupes found!

				?>
				<div> 
					<p><?php _e('I have just checked, and you have no detected duplicate posts right now.','delete_duplicate_posts');?></p>
					<p>
						<?php

						$nextscheduled = wp_next_scheduled('ddp_cron');

						if ($nextscheduled) _e('You have enabled CRON, so I am running on automatic. I will take care of everything...','delete_duplicate_posts');

						if ($nextscheduled) echo _e("<p>Next automatic check: <strong>$nexttime</strong><small><em>(Server Time Now:".date('l jS \of F Y H:i ',time()).")</em></small></p>", 'delete_duplicate_posts');

						if (!$nextscheduled) echo "You know what, <em>I can take care of every duplicate for you automatically</em>, <br>just go to the 'Configuration' tab and turn on CRON.";
						?>
					</p>


				</div>



				<?php
			}

			?>

		</div>			
 

		<div id="configuration">
			<h3><?php _e('Configuration', 'delete_duplicate_posts'); ?></h3>  

			<form method="post" id="delete_duplicate_posts_options">
				<?php wp_nonce_field('ddp-update-options'); ?>
				<table width="100%" cellspacing="2" cellpadding="5" class="form-table">

					<th colspan=2><h4><?php _e('Automatic (CRON) Settings', 'delete_duplicate_posts'); ?></h4></th>
					<tr valign="top"> 
						<th><label for="ddp_enabled"><?php _e('Enable CRON?:', 'delete_duplicate_posts'); ?></label></th><td><input type="checkbox" id="ddp_enabled" name="ddp_enabled" <?php if ($this->options['ddp_enabled']==true) echo 'checked="checked"' ?>>
						<p><em><?php _e('Clean duplicates automatically', 'delete_duplicate_posts'); ?></em></p>
					</td>
				</tr>

				<th><label for="ddp_keep"><?php _e('Delete which posts?:', 'delete_duplicate_posts'); ?></label></th><td>

				<select name="ddp_keep" id="ddp_keep">
					<option value="oldest" <?php if ($this->options['ddp_keep']=='oldest') echo 'selected="selected"'; ?>><?php _e('Keep oldest post','delete_duplicate_posts'); ?></option>
					<option value="latest" <?php if ($this->options['ddp_keep']=='latest') echo 'selected="selected"'; ?>><?php _e('Keep latest post','delete_duplicate_posts'); ?></option>
				</select>


				<p><em><?php _e('Keep the oldest or the latest version of duplicates? Default is keeping the oldest, and deleting any subsequent duplicate posts', 'delete_duplicate_posts'); ?></em></p>
			</td>
		</tr> 
		<th><label for="ddp_statusmail"><?php _e('Send status mail?:', 'delete_duplicate_posts'); ?></label></th><td><input type="checkbox" id="ddp_statusmail" name="ddp_statusmail" <?php if ($this->options['ddp_statusmail']==true) echo 'checked="checked"'; ?>>
		<p><em><?php _e('Sends a status email if duplicates have been found.', 'delete_duplicate_posts'); ?></em></p>
	</td>
</tr> 

<tr valign="top"> 
	<th><label for="ddp_limit"><?php _e('Delete at maximum :', 'delete_duplicate_posts'); ?></label></th><td><select name="ddp_limit">
	<?php
	for($x = 1; $x <= 8; $x++) {
		$val=($x*25);
		echo "<option value='$val' ";
		if ($this->options['ddp_limit']==$val) echo "selected"; 
		echo ">$val</option>";
	}
	?> 
</select> <?php _e('duplicates.', 'delete_duplicate_posts'); ?>
<p><em><?php _e('Setting a limit is a good idea, especially if your site is on a busy server.', 'delete_duplicate_posts'); ?></em></p>

</td>
</tr>



<th colspan=2><input type="submit" class="button-primary" name="delete_duplicate_posts_save" value="<?php _e('Save Settings', 'delete_duplicate_posts'); ?>" /></th>
</tr>

</table>

</form>
</div>


	<div id="log">

		<h3><?php _e('The Log', 'delete_duplicate_posts'); ?></h3>
		<textarea rows="32" class="large-text" name="ddp_log" id="ddp_log"><?php
		$table_name_log = $wpdb->prefix . "delete-duplicate-posts_log";	
		$query = "SELECT * FROM `".$table_name_log."` order by `id` ASC";
		$loghits = $wpdb->get_results($query, ARRAY_A);
		if ($loghits){
			foreach ($loghits as $hits) {
				echo $hits['note']."\n";
			}
		}		

		?></textarea>
		<p>
			<form method="post" id="ddp_clearlog">
				<?php wp_nonce_field('ddp_clearlog_nonce'); ?>

				<input class="button-secondary" type="submit" name="ddp_clearlog" value="<?php _e('Reset log','delete_duplicate_posts'); ?>" />
			</form>
		</p> 

	</div>

	<div id="help">
		<h3><?php _e('Help', 'delete_duplicate_posts'); ?></h3>
		<h4><php _e('What does this plugin do?','delete_duplicate_posts'); ?></h4>		
		<p><?php _e('Helps you clean duplicate posts from your blog. The plugin checks for blogposts on your blog with the same title.','delete_duplicate_posts'); ?></p>
		<p><?php _e("It can run automatically via WordPress's own internal CRON-system, or you can run it automatically.",'delete_duplicate_posts'); ?></p>	
		<p><?php _e('It also has a nice feature that can send you an e-mail when Delete Duplicate Posts finds and deletes something (if you have turned on the CRON feature).','delete_duplicate_posts'); ?></p>
		<h4><?php _e('Help! Something was deleted that was not supposed to be deleted!','delete_duplicate_posts'); ?></h4>	
		<p><?php _e('I am sorry for that, I can only recommend you restore the database you took just before you ran this plugin.','delete_duplicate_posts'); ?></p>
		<p><?php _e('If you run this plugin, manually or automatically, it is at your OWN risk!','delete_duplicate_posts'); ?></p>

		<p><?php _e('I have done my best to avoid deleting something that should not be deleted, but if it happens, there is nothing I can do to help you.','delete_duplicate_posts'); ?></i></p>

		<p><a href="http://cleverplugins.com" target="_blank">cleverplugins.com</a>.</p>
	</div><!-- #help -->
</div>




<?php
	}


  } //End Class
} 

if (class_exists('delete_duplicate_posts')) {
	$delete_duplicate_posts_var = new delete_duplicate_posts();
}
?>