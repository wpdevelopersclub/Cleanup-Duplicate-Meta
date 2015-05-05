<?php namespace Cleanup_Dup_Meta\Models;

/**
 * Model class - models a Post or User Meta
 *
 * @package     Cleanup_Dup_Meta\Models
 * @since       1.0.0
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

abstract class Model implements I_Model {

	/**
	 * Db Table to be cleaned (minus the prefix)
	 *
	 * @var string
	 */
	protected $table = 'postmeta';

	/**
	 * Configuration array
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Instantiate the Cleanup object
	 *
	 * @since 1.0.0
	 *
	 * @param array     $config     Configuration array
	 * @return self
	 */
	public function __construct( $config = array() ) {
		$this->config   = $config;
		$this->table    = $config['table'];

		$this->init_hooks();
	}

	/**
	 * Initialize the hooks
	 */
	protected function init_hooks() {
		add_action( "wp_ajax_cleanup_duplicate_{$this->table}", array( $this, 'ajax_cleanup') );
		add_action( "wp_ajax_count_duplicate_{$this->table}",   array( $this, 'ajax_count') );
	}

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer              Returns the number of rows affected to the browser
	 */
	public function ajax_cleanup() {

		//* nonce check
		check_admin_referer( $this->config['nonce'], 'security' );

		global $wpdb;

		//* To keep the first record (lowest meta_id), we use MIN;
		//* else the last record (max meta_id) is kept.
		$q_keep_which = 'first' == $_REQUEST['keep_first'] ? 'MIN' : 'MAX';

		$query_sql = $this->get_cleanup_sql( $q_keep_which );

		echo $wpdb->query( $query_sql );

		//* Check if doing AJAX, which makes it testable
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			die();
		}
	}

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Returns the number of duplicates
	 */
	public function ajax_count() {

		check_admin_referer( $this->config['nonce'], 'security' );

		global $wpdb;

		$query_sql = $this->get_count_sql();

		$count = $wpdb->get_var( $query_sql );

		echo false === $count ? -1 : $count;

		//* Check if doing AJAX, which makes it testable
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			die();
		}
	}

	/**
	 * Render the HTML for this model
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render() {
		include( $this->config['view'] );
	}

	/*************************
	 * Helpers
	 ************************/

	/**
	 * Get the SQL query string for the postmeta
	 *
	 * @since 1.0.0
	 *
	 * @param bool      $q_keep_which   Flag to set retaining the
	 *                                  first duplicate record (discard all dups)
	 * @return string                   Returns the SQL query string
	 */
	abstract protected function get_cleanup_sql( $q_keep_which = false  );

	/**
	 * Get the SQL query string for the number of duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return string   Returns the SQL query string
	 */
	abstract protected function get_count_sql();

	/****************************
	 * Getters
	 ***************************/

	/**
	 *  Get the property's value
	 *
	 * @since 1.0.0
	 *
	 * @param string    $property
	 * @return mixed
	 */
	public function __get( $property ) {
		return $this->get_property( $property );
	}

	/**
	 * Get the property's value
	 *
	 * @since 1.0.0
	 *
	 * @param string    $property
	 * @param mixed     $default_value
	 * @return mixed
	 */
	public function get( $property, $default_value = null ) {
		return property_exists( $this, $property )
			? $this->$property
			: $default_value;
	}
}