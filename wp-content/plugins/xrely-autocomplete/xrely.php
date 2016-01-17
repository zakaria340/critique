<?php

/**
 * Plugin Name: Xrely Autocomplete.
 * Plugin URI: http://autocomplete.xrely.com
 * Description: Xrely Autocomplete provieds rich and fastest autocomplete and correction feature to your website search.
 * Version: 1.0.2
 * Author: Jugal
 * Author URI: http://autocomplete.xrely.com
 * Text Domain: Optional. Plugin's text domain for localization. Example: mytextdomain
 * Domain Path: Optional. Plugin's relative directory path to .mo files. Example: /locale/
 * Network: Optional. Whether the plugin can only be activated network wide. Example: true
 * License: A short license name. Example: GPL2
 */
define('XRELY_VERSION', '3.0.4');
define('XRELY__MINIMUM_WP_VERSION', '3.1');
define('XRELY__PLUGIN_URL', plugin_dir_url(__FILE__));
define('XRELY__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('XRELY_DELETE_LIMIT', 100000);
define('XRELY_SITE_URL', "http://autocomplete.xrely.com/");
define('XRELY_WEB_SERVICE_DISCOVERY_URL', XRELY_SITE_URL . "Discovery/");
define('XRELY_SERVICE_DOMAIN', XRELY_SITE_URL);

require_once( XRELY__PLUGIN_DIR . 'class.xrely.php' );

if (is_admin())
{
    require_once( XRELY__PLUGIN_DIR . 'class.xrely-admin.php' );
    add_action('init', array('Xrely_Admin', 'init'));
} else
{
    if (get_site_option("xrely_active") == 'enable')
    {
       add_action('wp_footer', array('Xrely', 'add_xrely_script_tag'));
    }
}