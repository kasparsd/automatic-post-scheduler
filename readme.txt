=== Automatic Post Scheduler ===
Contributors: tetele
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=P6XRBCAL8BLF4&lc=RO&item_name=Automatic%20Post%20Scheduler&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: posts, schedule, post status, future
Requires at least: 2.0.2
Tested up to: 3.0.1
Stable tag: 0.9

A plugin that automatically schedules posts depending on a min/max threshold and the last post's publish date and time.

== Description ==

This plugin can be used for defining an editorial plan. WP already does a great job with the Scheduled post status, but what if it could be simpler than that?

When publishing posts, the plugin computes the most recent interval when a post can be published and picks a timestamp in that interval when to publish the post. If the selected interval has already passed since the newest post was published and there are no scheduled posts in the queue, then the new post will automatically be published. 

The plugin alters the default behavior of WP when publishing posts from the interface or using code (e.g. `wp_insert_post()`).  

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to *Settings* > *Writing* and choose min/max interval between posts
1. Publish posts in rapid succession

== Frequently Asked Questions ==

= How do I select the minimun and maximum interval boundaries? =

Go to *Settings* > *Writing* in your WP admin.

== Changelog ==

= 0.9 =
* Initial version