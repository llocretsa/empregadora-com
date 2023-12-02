=== Resume Manager ===
Contributors: mikejolley, kraftbj, tripflex, danjjohnson, aheckler, bryceadams, fitoussi, jakeom, alexsanford1, onubrooks
Requires at least: 5.0
Tested up to: 6.2
Stable tag: 2.0.0
License: GNU General Public License v3.0

Manage candidate resumes from the WordPress admin panel, and allow candidates to post their resumes directly to your site.

= Documentation =

Usage instructions for this plugin can be found here: [https://wpjobmanager.com/documentation/add-ons/resume-manager/](https://wpjobmanager.com/documentation/add-ons/resume-manager/).

= Support Policy =

For support, please visit [https://wpjobmanager.com/support/](https://wpjobmanager.com/support/).

We will not offer support for:

1. Customisations of this plugin or any plugins it relies upon
2. Conflicts with "premium" themes from ThemeForest and similar marketplaces (due to bad practice and not being readily available to test)
3. CSS Styling (this is customisation work)

If you need help with customisation you will need to find and hire a developer capable of making the changes.

== Installation ==

To install this plugin, please refer to the guide here: [http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation)

== Changelog ==

2023-10-10 - version 2.0.0
* Fix: Fix date pickers for dynamically added resume sections
* Fix: Only load resume scripts on relevant pages
* Tweak: Scroll to top of resume list after page change
* Fix: Fix embeds for resumes
* Tweak: Only show skills if skills are enabled in the settings

2023-06-10 - version 1.19.1
* Fix: Fix PHP 8.2 deprecations #81

2023-05-03 - version 1.19.0
Update: Add author support for the Post Type just like WPJM core
Bugfix: Fix a typo in the installation text
Bugfix: Fix phpcs dependency issues
Bugfix: Template security improvements
Bugfix: Add language pack deploy command
Bugfix: Remove unused jQuery dependencies
Bugfix: Update jQuery deprecated functions
Update: Add action to save resume skills to postmeta
Bugfix: Fix extra whitespace in 'Apply with Resume' textarea
Bugfix: Add user login to correct method call

2022-01-24 - version 1.18.6
Bugfix: Improve handling of search fields

2021-12-03 - version 1.18.5
- Bump tested up to version to 5.8.
- Dev: Improve the handling of meta data and add REST support. (@Gnodesign)
- Dev: Add filters for [resumes] shortcode output, matching WP Job Manager core. (@tripflex)
- Change: Use the new wp_robots filter when it's available instead of wp_no_robots().
- Fix: Make category dropdown automatically resize based on window width on resumes page.
- Feature: New skills input to search for resumes by skills on the frontend.
- Feature: Ability to sort by skills and featured columns on admin.
