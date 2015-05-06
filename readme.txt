=== Cleanup Duplicate Meta ===
Contributors: WPDevelopersClub, hellofromTonya
Tags: meta, post meta, user meta, duplicate meta, database cleanup, cleanup, clean up, database
Requires at least: 3.3
Tested up to: 4.2.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Cleanup Duplicate Meta gives you a tool to check for and delete duplicate Post and/or User Meta entries in the database tables.

== Description ==

There are times when your database gets filled up with duplicate entries that you may not want.  Cleanup Duplicate Meta allows you to check for any duplicates in either the Post Meta or User Meta tables.  Then if you want to get rid of them, simply click on the Cleanup button and Cleanup Duplicate Meta deletes the duplicates leaving either the first or last meta (you select which).

The interface is simple and easy to use.
1. 'Check for Duplicates' queries the database and then displays all the duplicates found.
2. 'Count Duplicates' counts all the duplicates found in the database (i.e. a total count).
3. The 'Cleanup' buttons trigger a SQL query to run, which deletes each of the duplicate entries, leaving either the first or last one (per your selection) in the database.  All non-duplicates remain untouched by the plugin.

See the [screenshots tab](http://wordpress.org/extend/plugins/cleanup-duplicate-meta/screenshots/) for more details.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Cleanup Duplicate Meta'
3. Activate Cleanup Duplicate Meta from your Plugins page.

= Once Activated =

1. Go to 'Tools > Cleanup Duplicates'
2. Click on the 'Check for Duplicates' button for either Post or User Meta.
3. If there are duplicates, you can then click on 'Cleanup Post Meta' or 'Cleanup User Meta' button.

== Frequently Asked Questions ==

= How do I check how many duplicates are in either the Post Meta or User Meta table? =

Simply click on the 'Check for Duplicates' button and the plugin will report the count back to you on the screen.

See the [screenshot 2](http://wordpress.org/extend/plugins/cleanup-duplicate-meta/screenshots/) for an example.

= How do I know whether to leave the first or last one? =

If you know which one you want, then select either the first or last one.  Otherwise, leave it at the default.

= Should I backup my database first? =

Yes. Before you run Cleanup, you should backup your database.

= Will this work on WordPress multisite? =

Yes!

= What happens to non-duplicates when I run Cleanup? =

Nothing.  Cleanup Duplicate Meta does not touch non-duplicates.  Therefore you're data remains intact.

== Screenshots ==

1. The plugin's page in Tools > 'Cleanup Duplicates'.
2. Screen for both the Post Meta and User Meta controls.
3. An example of the table generated when clicking on 'Check for Duplicates' button.  The results are sorted by meta key.
4. After clicking on the 'Count Duplicates' button, notification is displayed of the number of duplicates found (which could be deleted).
5. The message after clicking on 'Cleanup Post Meta'.

== ChangeLog ==

= Version 1.0.1 =

* First release