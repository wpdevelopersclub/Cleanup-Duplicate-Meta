<?php namespace Cleanup_Dup_Meta\Models;

/**
 * Model class - models a Post or User Meta
 *
 * @package     Cleanup_Dup_Meta\Models
 * @since       1.0.1
 * @author      WP Developers Club and Tonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

class Model implements I_Model {

	/**
	 * Db Table to be cleaned (minus the prefix)
	 *
	 * @var string
	 */
	protected $type = '';

	/**
	 * Db Table to be cleaned
	 *
	 * @var string
	 */
	protected $tablename = '';

	/**
	 * Security nonce action
	 *
	 * @var string
	 */
	protected $nonce = '';

	/**
	 * AJAX Actions
	 *
	 * @var array
	 */
	protected $actions = array();

	/**
	 * Database columns unique to this Model
	 *
	 * @var array
	 */
	protected $columns = array();

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
		$this->config       = $config;
		$this->type         = $config['type'];
		$this->tablename    = $config['tablename'];
		$this->columns      = $config['columns'];
		$this->nonce        = '_cleanup_duplicates_' . $config['type'];

		$this->actions      = array(
			'cleanup'       => 'cleanup_dupmeta_' . $this->type,
			'count'         => 'cleanup_dupmeta_count_' . $this->type,
			'query'         => 'cleanup_dupmeta_query_' . $this->type,
		);

		$this->init_hooks();
	}

	/**
	 * Initialize the hooks
	 */
	protected function init_hooks() {
		add_action( "wp_ajax_cleanup_dupmeta_{$this->type}",        array( $this, 'ajax_cleanup') );
		add_action( "wp_ajax_cleanup_dupmeta_count_{$this->type}",  array( $this, 'ajax_count') );
		add_action( "wp_ajax_cleanup_dupmeta_query_{$this->type}",  array( $this, 'ajax_query_for_duplicates') );
	}

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer              Returns the number of rows affected to the browser
	 */
	public function ajax_cleanup() {

		// nonce check
		check_ajax_referer( $this->nonce, 'security' );

		global $wpdb;

		// To keep the first record (lowest meta_id), we use MIN;
		// else the last record (max meta_id) is kept.
		$q_keep_which = 'first' == $_POST['keep_first'] ? 'MIN' : 'MAX';

		$query_sql = $this->get_cleanup_sql( $q_keep_which );

		echo $wpdb->query( $query_sql );

		wp_die();
	}

	/**
	 * Handles the callback from AJAX
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Returns the number of duplicates
	 */
	public function ajax_count() {

		check_ajax_referer( $this->nonce, 'security' );

		global $wpdb;

		$query_sql = $this->get_count_sql();

		echo $wpdb->get_var( $query_sql );

		wp_die();
	}

	/**
	 * Handles the callback from AJAX for fetching all of the duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return integer   Renders out a table of the duplicates
	 */
	public function ajax_query_for_duplicates() {
		check_ajax_referer( $this->nonce, 'security' );

		global $wpdb;

		$results = $wpdb->get_results( $this->get_duplicates_sql() );

		if ( empty( $results ) ) {
			_e( 'No duplicates found', 'cleanup_dup_meta' );
		} else {
			$this->render( 'duplicates.php', $results );
		}

		wp_die();
	}

	/**
	 * Render the HTML for this model
	 *
	 * @since 1.0.0
	 *
	 * @param string    $filename
	 * @param array     $local_variables
	 * @return null
	 */
	public function render( $filename = 'meta.php', $local_variables = array() ) {
		include( CLEANUP_DUP_META_PLUGIN_DIR . 'lib/views/' . $filename );
	}

	/*************************
	 * Helpers
	 ************************/

	/**
	 * Get the SQL query string for cleanup
	 *
	 * @since 1.0.0
	 *
	 * @param string    $q_keep_which   MIN retains the first duplicate record
	 *                                  (discard all dups); MAX retains the last.
	 *                                  Default: MAX
	 * @return string                   Returns the SQL query string
	 */
	protected function get_cleanup_sql( $q_keep_which = 'MAX' ) {
		return	"DELETE FROM {$this->tablename}" . $this->get_where_sql( $q_keep_which );
	}

	/**
	 * Get the SQL query string for the number of duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return string   Returns the SQL query string
	 */
	protected function get_count_sql() {
		return	"SELECT COUNT(*) FROM {$this->tablename}" . $this->get_where_sql( 'MIN' );
	}

	/**
	 * Get the SQL query string for the number of duplicates
	 *
	 * @since 1.0.0
	 *
	 * @return string   Returns the SQL query string
	 */
	protected function get_duplicates_sql() {
		return "SELECT * FROM {$this->tablename}" . $this->get_where_sql( 'MIN', ' ORDER BY meta_key;' );
	}

	/**
	 * Get the WHERE SQL query string
	 *
	 * @since 1.0.0
	 *
	 * @param string    $q_keep_which   MIN retains the first duplicate record
	 *                                  (discard all dups); MAX retains the last.
	 *                                  Default: MAX
	 * @param string    $suffix         Append the semi-colon to the end.
	 * @return string                   Returns the WHERE SQL query string
	 */
	protected function get_where_sql( $q_keep_which = 'MAX', $suffix = ';' ) {
		return " WHERE {$this->columns['primary_id']} NOT IN (
					SELECT *
					FROM (
						SELECT {$q_keep_which}({$this->columns['primary_id']})
						FROM {$this->tablename}
						GROUP BY {$this->columns['id']}, meta_key
					) AS x
				){$suffix}";
	}

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
		return $this->get( $property );
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