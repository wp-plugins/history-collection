=== History Collection ===
Contributors: bpcombs

Donate Link: https://www.paypal.com/cgi-bin/webscr?business=payments@ionadas.com&cmd=_xclick&currency_code=USD&amount=5&item_name=History%20Collection

Tags: History collection, history, histories,today in history, sidebar, widget, shortcode

Requires at least: 2.8

Tested up to: 3.4.1
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

History Collection plugin helps you collect and display daily historical entries on your WordPress blog. 

== Description ==

History Collection allows you to create a "Today in History" section on your site, inserted either through a shortcode or a sidebar widget.

The output of this can be seen here:

http://www.briancombs.net/today-in-texas-longhorn-history/

We're working on inputing listings, but any particular date might not have information yet.

== Installation ==

1. Upload the `history-collection` directory to the `/wp-content/plugins/` directory

1. Activate the 'history Collection' plugin through the 'Plugins' menu in WordPress

1. Add and manage the histories through the 'History' menu in the WordPress admin area

1. To display a history in the sidebar, go to 'Widgets' menu and drag the 'History' widget into the sidebar.
1. To display a history in a Page or Post, use one of the shortcodes as detailed below.

= Adding Listings =

After the plugin is activated, a Menu for "History" will be added to the WordPress management menu. To add or manage listings, go to the "Listing" submenu.

At the bottom of this page is the "Add new history" section. It consists of several fields:

Title: A short headline for the listing.
Description: A longer body of text with more detail. In theory, this can be quite long, but anything longer than a sentence or two is likely to cause problems with display on the Widget.

Day: The day of the month when the event occurred.

Month: The numeric month when the event occurred.

Year: The year when the month occurred.

Tags: Tags can be used to limit the output to a particular topic. Should be comma separated if you have more than one.

Public?: A check box that allows you to turn a particular list on or off as far as the output is concerned.

= Settings =

The Settings page is only accessible to those with Admin permissions. It allows you to set several functions, including:

Date Format: How the date on the output is formatted.

Minimum User Role to Edit Listings: Control who can add or edit listings.

Ordering of Multiple Listings: Determine how output is ordered when there is more than one listing.

Link to Plugin Author?: Provide a much appreciated link to this plugin's author on your output.

There is also the ability to make a PayPal donation to support the development of this plugin. Anything helps!

= Shortcodes =

The data in the plugin can be outputted on a WordPress Page or Post using a shortcode. The following shortcodes are supported:

[todayhistory] : Outputs the listings for the current day and month.

[weeklyhistory] : Outputs the listings for the current week.

[monthlyhistory] : Outputs the listings for the current month.

[fullhistory] : Outputs all listings.

The output can be further limited using the variable "tags" within the shortcode. Multiple tags should be comma separated, and might look like:

[todayhistory tags="lorem"]
[todayhistory tags="lorem,football,hi"]
[weeklyhistory tags="lorem,football,hi"]
[monthlyhistory tags="lorem"]
[monthlyhistory tags="lorem,football,hi"]
[fullhistory tags="lorem"]
[fullhistory tags="lorem,football,hi"]

= Widgets =

Listings can also be outputted to a sidebar using the "History" widget. Simply drag the "History" widget to the desired sidebar, and choose your settings.

Title: The headline for that section on the sidebar.

Show title?: A checkbox allowing you to turn on or off the Title for individual listings (to save space, for instance).

Show tags?: A checkbox allowing you to turn on or off the display of tags.

Show limit: Allows you to limit how many listings are displayed on a particular date (to save space).

Currently, you can't limit Widget output by tag, but this will be added in a future version.

For more information, visit the [plugin homepage](#). Please provide your feedback at the [WordPress support forums].

= The [todayhistory] shortcode =

histories can be displayed in a page by placing the shortcode `[todayhistory]`. This will display all the history in current date.

histories can be displayed in a page by placing the shortcode `[weeklyhistory]`. This will display all the history in current week.

histories can be displayed in a page by placing the shortcode `[monthlyhistory]`. This will display all the history in current month.

histories can be displayed in a page by placing the shortcode `[fullhistory]`. This will display all the histories.

= Import/Export =

You can now upload and download CSV files of all your listings. We highly recommend that you occasionally download your listings so that you have a backup of them in case of a database crash. Simply go to the Import/Export screen, and download the history to get a datafile of all your listings.

You can also upload a number of listings at once by downloading the Sample CSV file, populating it with history listing data, and then uploading it back into the system. Note: This will append to current listings, so if you upload the file you downloaded as a backup, you'll have a bunch of duplicate listings.

== Screenshots ==

1. Listings page - Previously entered listings
2. Listings page - New listing data entry
3. Settings Page
4. Shortcode output on WordPress Page - No entries
5. Shortcode output on WordPress Page - Sample entry
6. Widget management
7. Widget output
8. Import/Export page

== Frequently Asked Questions ==

= How can I replace all the listings in my database? =

We decided not to add this as a function, as the risk of accidentally erasing everything was just too high. But there is a work around.

Download your entire History from the database using the Import/Export screen. You can then load it into Excel to remove duplicates, find spelling errors, and so forth.

Then, once you're ready to re-upload the listings, you can go to the Listings page and use the Bulk Action to erase your listings. Yes, if you have multiple screens of listings, this could still take a long time.

Once they're all deleted, you can re-upload your CSV to get the listings back.

Just be sure your CSV is ready to go. Once you delete them from the system, the only way to get them back will be to re-upload them. Be careful!

== Changelog ==

= 1.1.1 =
Fixed a bug that added a slash to Titles that had an apostrophe, and added an import/export system.

= 1.0.2 =
Bug fix of an error in the shortcode display code.

= 1.0.1 =
Minor edits to conform to WordPress.org standards.

= 1.0 =
Initial submission to WordPress.org.

= 0.5b =

This version is a private beta for third party testing.

== Upgrade Notice ==

= 1.0.2 =
Bug fix of an error in the shortcode display code.

= 1.0.1 =
This is the first public release, so you're downloading, not upgrading.