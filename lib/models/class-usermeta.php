<?php namespace Cleanup_Dup_Meta\Models;

/**
 * User Meta Model class
 *
 * @package     Cleanup_Dup_Meta\Models
 * @since       1.0.0
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

class User_Meta extends Model {

	/**
	 * Db Table to be cleaned (minus the prefix)
	 *
	 * @var string
	 */
	protected $table = 'usermeta';

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
	protected function get_cleanup_sql( $q_keep_which = 'MAX' ) {
		global $wpdb;

		return	"
				DELETE FROM {$wpdb->usermeta}
				WHERE umeta_id NOT IN (
					SELECT *
					FROM (
						SELECT {$q_keep_which}(umeta_id)
						FROM  {$wpdb->usermeta}
						GROUP BY user_id, meta_key
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
				SELECT COUNT(*) FROM {$wpdb->usermeta}
				WHERE umeta_id NOT IN (
					SELECT *
					FROM (
						SELECT MIN(umeta_id)
						FROM  {$wpdb->usermeta}
						GROUP BY user_id, meta_key
					) AS x
				);
				";
	}
}