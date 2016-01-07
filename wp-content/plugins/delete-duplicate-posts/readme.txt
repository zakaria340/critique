=== Plugin Name ===
Contributors: lkoudal
Donate link: http://cleverplugins.com/
Tags: delete, posts, post, duplicate, SEO, duplicate post, duplicate posts
Requires at least: 3.4
Tested up to: 4.0
Stable tag: 3.1

Delete the duplicate posts on your WordPress blog.

== Description ==

Get rid of duplicate blogposts on your blog. This plugin searches for blogposts with identical titles and keeps the oldest (or newest, you can configure this) and deletes the rest. The plugin also deletes meta data for the blogposts it deletes.



== Installation ==

1. Download the .zip file
2. Extract the zip-file, containing the folder "delete-duplicate-posts"
3. Upload to your wp-content/plugins/ folder on your blog
4. Log in to your blog, go to the plugins page and look for "Delete Duplicate Posts" and activate the plugin
5. You can now access the plugin in your "Tool" menu under "Delete Duplicate Posts"


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

= 2.2.2 =
* Bugfix where DDP sometimes deleted menu items: http://wordpress.org/support/topic/plugin-delete-duplicate-posts-the-plugin-breaks-my-menu

= 2.2.1 =
* Adding option to remove the footer link.
* Updated help section regarding the CleverPlugins.com ad which is now always shown on the plugin settings page.

= 2.2 =
* New feature: Keep either the oldest or latest post (default is 'oldest'). Feature suggested by Adam Kochanowicz
* New feature: W3 Total Cache pages and WP Super Cache compability.
* Several minor fixes, code optimizations, etc.
* WordPress 3.1 compatibility verified.

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
* Bugfix : Now actually deletes duplicate posts when clicking the button manually.. Doh...:-/

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

= 1.0 =
* First release


== Frequently Asked Questions ==

= What happens to my duplicate posts? =

All of them will be completely erased from the database. There is no recovery option. Remember to back up your database first in case a mistake happens!


