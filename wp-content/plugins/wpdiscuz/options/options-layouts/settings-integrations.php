<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Integrations', 'wpdiscuz'); ?></h2>   
    <table class="wp-list-table widefat plugins" style="margin-top:10px; border:none;" width="75">
        <tbody>
            <tr valign="top">
                <td>
                    <div id="integrationsChild">
                        <ul class="resp-tabs-list integrationsChild">
                            <li><?php _e('BuddyPress', 'wpdiscuz'); ?></li>
                            <li><?php _e('Users Ultra', 'wpdiscuz'); ?></li>
                            <li><?php _e('User Pro', 'wpdiscuz'); ?></li>
                            <li><?php _e('Ultimate Member', 'wpdiscuz'); ?></li>
                            <li><?php _e('MyCred', 'wpdiscuz'); ?></li>
                        </ul>
                        <div class="resp-tabs-container integrationsChild">
                            <div>
                                <div style="width:100%; display:block;">
                                    <h3 style="margin-bottom:5px;">Please add the code below in current active theme's functions.php file </h3>
                                    <p>This code will integrate BuddyPress profile URL with wpDiscuz. BuddyPress Display Names and Avatars will be integrated automatically.</p>
                                    <pre style="color:#006666; background-color:#FFF4EA; font-size:12px; padding:10px 20px 10px 20px; width:98%; overflow:auto;box-sizing:border-box;">
////////////////////////////////////////////////////////////////////////
// BuddyPress Profile URL Integration //////////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_bp_profile_url', 10, 2);
function wpdiscuz_bp_profile_url($profile_url, $user) {
    if ($user) {
        if (class_exists('BuddyPress')) {
            $profile_url = bp_core_get_user_domain($user->ID);
        }
    }
    return $profile_url;
}
                                    </pre>
                                </div>
                            </div>
                            <div>
                                <div style="width:100%; display:block;">
                                    <h3 style="margin-bottom:5px;">Please add the code below in current active theme's functions.php file </h3>
                                    <p>This code will integrate Users Ultra profile URL with wpDiscuz. Users Ultra Display Names and Avatars will be integrated automatically.</p>
                                    <pre style="color:#006666; background-color:#FFF4EA; font-size:12px; padding:10px 20px 10px 20px; width:98%; overflow:auto;box-sizing:border-box;">
////////////////////////////////////////////////////////////////////////
// Users Ultra Profile URL Integration /////////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_uu_profile_url', 10, 2);
function wpdiscuz_uu_profile_url($profile_url, $user) {
    if ($user) {
        if (class_exists('XooUserUltra')) {
            global $xoouserultra; $profile_url = $xoouserultra->userpanel->get_user_profile_permalink($user->ID);
        }
    }
    return $profile_url;
}
                                    </pre>
                                </div>
                            </div>
                            <div>
                                <div style="width:100%; display:block;">
                                    <h3 style="margin-bottom:5px;">Please add the code below in current active theme's functions.php file </h3>
                                    <p>This code will integrate User Pro profile URL with wpDiscuz. User Pro Display Names and Avatars will be integrated automatically.</p>
                                    <pre style="color:#006666; background-color:#FFF4EA; font-size:12px; padding:10px 20px 10px 20px; width:98%; overflow:auto;box-sizing:border-box;">
////////////////////////////////////////////////////////////////////////
// User Pro Profile URL Integration ////////////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_up_profile_url', 10, 2);
function wpdiscuz_up_profile_url($profile_url, $user) {
    if ($user) {
        if (class_exists('userpro_api')) {
            global $userpro; $profile_url = $userpro->permalink($user->ID);
        }
    }
    return $profile_url;
}
                                    </pre>
                                </div>
                            </div>

                            <div>

                                <div style="width:100%; display:block;">
                                    <h3 style="margin-bottom:5px;">Please add the code below in current active theme's functions.php file </h3>
                                    <p>This code consists of two parts, which will integrate Ultimate Member profile Display Name and Profile URL with wpDiscuz. UM Avatars will be integrated automatically.</p>
                                    <pre style="color:#006666; background-color:#FFF4EA; font-size:12px; padding:10px 20px 10px 20px; width:98%; overflow:auto;box-sizing:border-box;">             
////////////////////////////////////////////////////////////////////////
// Ultimate Member Profile Display Name Integration ////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_comment_author', 'wpdiscuz_um_author', 10, 2);
function wpdiscuz_um_author($author_name, $comment) {
    if ($comment-&gt;user_id) {
        $column = 'display_name'; // Other options: 'user_login', 'user_nicename', 'nickname', 'first_name', 'last_name'
        if (class_exists('UM_API')) {
            um_fetch_user($comment-&gt;user_id); $author_name = um_user($column); um_reset_user();
        } else {
            $author_name = get_the_author_meta($column, $comment-&gt;user_id);
        }
    }
    return $author_name;
}
////////////////////////////////////////////////////////////////////////
// Ultimate Member Profile URL Integration /////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_profile_url', 'wpdiscuz_um_profile_url', 10, 2);
function wpdiscuz_um_profile_url($profile_url, $user) {
    if ($user) {
        if (class_exists('UM_API')) { 
            um_fetch_user($user->ID); $profile_url = um_user_profile_url();
        }
    }
    return $profile_url;
}

                                    </pre>
                                </div>
                            </div>
                            <div>
                                <div style="width:100%; display:block;">
                                    <h3 style="margin-bottom:5px;">Please add the code below in current active theme's functions.php file </h3>
                                    <p>This code will integrate MyCred User Ranks and Badges under comment author avatar.</p>
                                    <pre style="color:#006666; background-color:#FFF4EA; font-size:12px; padding:10px 20px 10px 20px; width:98%; overflow:auto;box-sizing:border-box;">
////////////////////////////////////////////////////////////////////////
// MyCred User Ranks and Badges Integration ////////////////////////////
////////////////////////////////////////////////////////////////////////
add_filter('wpdiscuz_after_label', 'wpdiscuz_mc_after_label_html', 110, 2);
function wpdiscuz_mc_after_label_html($afterLabelHtml, $comment) {
    if ($comment->user_id) {
        // keep your preffered profile plugin and remove others...            
        if (function_exists('mycred_get_users_rank')) { //User Rank
            $afterLabelHtml .= mycred_get_users_rank($comment->user_id, 'logo', 'post-thumbnail', array('class' => 'mycred-rank'));
        }
        if (function_exists('mycred_get_users_badges')) { //User Badges
            $users_badges = mycred_get_users_badges($comment->user_id);
            if (!empty($users_badges)) {
                foreach ($users_badges as $badge_id => $level) {
                    $afterLabelHtml .= '&lt;img src="' . get_post_meta($badge_id, 'main_image', true) . '" 
                    width="24" height="24" class="mycred-badge earned" alt="' . get_the_title($badge_id) . '" 
                    title="' . get_the_title($badge_id) . '" /&gt;';
                }
            }
        }
        if (class_exists('userpro_api')) { // userpro user badges
            $afterLabelHtml .= userpro_show_badges($comment->user_id, $inline = true);
        }
    }
    return $afterLabelHtml;
}
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>        
        </tbody>
    </table>
</div>