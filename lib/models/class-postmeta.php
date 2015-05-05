<?php namespace Cleanup_Dup_Meta\Models;

/**
 * Post Meta Model class
 *
 * @package     Cleanup_Dup_Meta\Models
 * @since       1.0.0
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

class Post_Meta extends Model {

	/**
	 * Get the SQL query string for the postmeta
	 *
	 * @since 1.0.0
	 *
	 * @param string    $q_keep_which   MIN retains the first duplicate record
	 *                                  (discard all dups); MAX retains the last.
	 *                                  Default: MAX
	 * @return string                   Returns the SQL query string
	 */
	protected function get_cleanup_sql( $q_keep_which = 'MAX'  ) {
		global $wpdb;

		return	"
				DELETE FROM  {$wpdb->postmeta}
				WHERE meta_id NOT IN (
					SELECT *
					FROM (
						SELECT {$q_keep_which}(meta_id)
						FROM  {$wpdb->postmeta}
						GROUP BY post_id, meta_key
					) AS x
				);
				";
	}

	/**
	 * Get the SQL query string for the number of duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return string   Returns the SQL query string
	 */
	protected function get_count_sql() {
		global $wpdb;

		return	"
				SELECT COUNT(*) FROM {$wpdb->postmeta}
				WHERE meta_id NOT IN (
					SELECT *
					FROM (
						SELECT MIN(meta_id)
						FROM  {$wpdb->postmeta}
						GROUP BY post_id, meta_key
					) AS x
				);
				";
	}
}