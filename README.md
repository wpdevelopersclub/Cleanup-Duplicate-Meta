# Cleanup Duplicate Meta

WordPress Plugin that checks for and/or deletes duplicate Post and/or User Meta entries in the database tables

__Contributors:__ [Tonya](https://github.com/hellofromtonya)  
__Requires:__ WordPress 3.5  
__Tested up to:__ WordPress 4.2.1  
__License:__ [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.html) 

There are times when your database gets filled up with duplicate entries that you may not want.  Cleanup Duplicate Meta allows you to check for any duplicates in either the Post Meta or User Meta tables.  Then if you want to get rid of them, simply click on the Cleanup button and Cleanup Duplicate Meta deletes the duplicates leaving either the first or last meta (you select which).

The interface is simple and easy to use.

1. 'Check for Duplicates' queries the database and then displays all the duplicates found.  
2. 'Count Duplicates' counts all the duplicates found in the database (i.e. a total count). 
3. The 'Cleanup' buttons trigger a SQL query to run, which deletes each of the duplicate entries, leaving either the first or last one (per your selection) in the database.  All non-duplicates remain untouched by the plugin.    