# Cleanup Duplicate Meta

[![Code Climate](https://codeclimate.com/github/wpdevelopersclub/Cleanup-Duplicate-Meta/badges/gpa.svg)](https://codeclimate.com/github/wpdevelopersclub/Cleanup-Duplicate-Meta)

WordPress Plugin that checks for and/or deletes duplicate Post and/or User Meta entries in the database tables

__Contributors:__ [Tonya](https://github.com/hellofromtonya)  
__Requires:__ WordPress 3.3  
__Tested up to:__ WordPress 4.2.1  
__License:__ [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.html) 

There are times when your database gets filled up with duplicate entries that you may not want.  Cleanup Duplicate Meta allows you to check for any duplicates in either the Post Meta or User Meta tables.  Then if you want to get rid of them, simply click on the Cleanup button and Cleanup Duplicate Meta deletes the duplicates leaving either the first or last meta (you select which).

Clicking on the 'Check for Duplicates' will query the database and then report back on the screen how many duplicates were found, if any.

When clicking on the 'Cleanup Post Meta' or 'Cleanup User Meta' button, the plugin will run a SQL query to delete each of the duplicate entries except for either the first or last one (per your selection).  All non-duplicates remain untouched by the plugin.