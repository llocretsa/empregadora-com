=== Job Tags ===
Contributors: mikejolley
Requires at least: 6.0
Tested up to: 6.2
Stable tag: 1.4.4
License: GNU General Public License v3.0

Adds tags to Job Manager for tagging jobs with required Skills and Technologies. Also adds some extra shortcodes. Requires Job Manager 1.0.4+

= Documentation =

Usage instructions for this plugin can be found here: [https://wpjobmanager.com/document/job-tags/](https://wpjobmanager.com/document/job-tags/).

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

= 1.4.4 =
* Update plugin headers.

= 1.4.3 =
* Update uninstall logic to depend on Job Manager setting and remove tags.

= 1.4.2 =
* Fix jQuery 3.x compatibility.

= 1.4.1 =
* Fixes issue with WPJM CSS styles not loading on pages with `[jobs_by_tag]` and `[job_tag_cloud]` shortcodes.
* Fixes issue with tags not being editable in the block editor.

= 1.4.0 =
* Adds compatibility with WP Job Manager 1.29.0 and requires it for future updates.

= 1.3.8 =
* Fix search when tag search is empty.

= 1.3.7 =
* Allow tags to be searched when querying jobs manually.

= 1.3.6 =
* Fix - Set placeholder on multiselect.

= 1.3.5 =
* Support tag archive.

= 1.3.4 =
* No tags in category should hide tags selection.

= 1.3.3 =
* Show tags from lower-level categories.
* Filter to avoid lowercasing tags.

= 1.3.2 =
* Support upcoming job manager release.
* Convert slugs to ids to correctly filter tags.

= 1.3.1 =
* Fix filter.

= 1.3.0 =
* If using categories, tags will only show for jobs within those categories.

= 1.2.0 =
* Option to define whether tags query jobs with an AND or OR query.
* Fix active styles.

= 1.1.3 =
* Check for array when saving fields.

= 1.1.2 =
* Load translation files from the WP_LANG directory.
* Updated the updater class.

= 1.1.1 =
* Uninstaller.

= 1.1.0 =
* Support for 1.14.0 +
* Choose to show text field, checkboxes, or multiselect for tags.

= 1.0.9 =
* Fixed text domains

= 1.0.8 =
* Added new updater - This requires a licence key which should be emailed to you after purchase. Past customers (via Gumroad) will also be emailed a key - if you don't recieve one, email me.

= 1.0.7 =
* Add languages dir

= 1.0.6 =
* Update localisation

= 1.0.5 =
* Check if form_data is set.

= 1.0.4 =
* Fix multi-word tags

= 1.0.3 =
* Fix notices

= 1.0.2 =
* Fix tag filters
* Move JS to own file

= 1.0.1 =
* Fix when slugs differ from names

= 1.0.0 =
* First release.
