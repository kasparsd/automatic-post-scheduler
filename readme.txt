=== Automatic Post Scheduler ===
Contributors: tetele, kasparsd
Tags: posts, schedule, post status, future, scheduler, editorial, scheduling, automatic scheduling, queue posts, queue
Requires at least: 2.0.2
Tested up to: 4.5.2
Stable tag: trunk

A plugin that automatically schedules posts depending on a min/max threshold and the last post's publish date and time.


== Description ==

This plugin can be used for defining an editorial plan. WP already does a great job with the Scheduled post status, but what if it could be simpler than that?

When publishing posts, the plugin computes the most recent interval when a post can be published and picks a timestamp in that interval when to publish the post. If the selected interval has already passed since the newest post was published and there are no scheduled posts in the queue, then the new post will automatically be published.

The plugin alters the default behavior of WP when publishing posts from the interface or using code (e.g. `wp_insert_post()`).


== Installation ==

1. Upload `automatic-post-scheduler` to the `/wp-content/plugins/` directory.
2. Activate "Automatic Post Scheduler" through the "Plugins" menu in WordPress.
3. Go to *Settings* > *Writing* and choose the interval between scheduled posts.
4. Publish posts in rapid succession.


== Frequently Asked Questions ==

= How do I select the minimun and maximum interval boundaries? =

Go to *Settings* > *Writing* in your WP admin.

= Can I choose not to schedule a certain post? =

Yes, all you have to do is uncheck the *Schedule as soon as possible* box in the post publish box.


== Screenshots ==

1. Scheduling settings
2. Post scheduling option when publishing


== Changelog ==

= 0.9.5 =
* Tested with WordPress 4.5.2.

= 0.9.4 =
* Use more readable textdomain. Improve wording on the schedule settings page.

= 0.9.3 =
* Add translation support, sanitize string output, improve wording.

= 0.9.2 =
* Tested with WordPress 3.8.1
* *Bugfix* - Fix HTML of the scheduling checkbox
* *Bugfix* - Fix errors with WordPress Multisite (remove closing PHP tag and empty line)

= 0.9.1 =
* *New feature* - Ability to publish posts without scheduling them
* *New feature* - Ability for users to disable autoscheduling by default, even with the plugin activated
* *Bugfix* - Post not scheduled any more on update
* *Bugfix* - First save of settings made the values reset to 0
* *Bugfix* - Don't autoschedule pages

= 0.9 =
* Initial version
