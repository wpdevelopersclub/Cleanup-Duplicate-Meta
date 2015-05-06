<?php namespace Cleanup_Dup_Meta\Models;

/**
 * Model Contract
 *
 * @package     Cleanup_Dup_Meta\Models
 * @since       1.0.1
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

interface I_Model {

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Returns the number of rows affected to the browser
	 */
	public function ajax_cleanup();

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Returns the number of duplicates
	 */
	public function ajax_count();

	/**
	 * Handles the callback from AJAX for fetching all of the duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Renders out a table of the duplicates
	 */
	public function ajax_query_for_duplicates();

	/**
	 * Render the HTML for this model
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render();
}