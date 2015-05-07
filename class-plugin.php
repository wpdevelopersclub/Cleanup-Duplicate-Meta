<?php namespace Cleanup_Dup_Meta;

/**
 * Cleanup Duplicate Meta Plugin Class
 *
 * This class is the controller for the plugin, directly traffic, creating the
 * admin menu, etc.
 *
 * @package     Cleanup_Dup_Meta
 * @since       1.0.1
 * @author      WPDevelopersClub and hellofromTonya
 * @link        http://wpdevelopersclub.com/wordpress-plugins/cleanup-duplicate-meta/
 * @license     GNU General Public License 2.0+
 * @copyright   2015 WP Developers Club
 */

use Cleanup_Dup_Meta\Models\I_Model;

//* Oh no you don't. Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheating&#8217; uh?' );
}

class Plugin {

	/**
	 * The plugin's version
	 *
	 * @var string
	 */
	const VERSION = '1.0.1';

	/**
	 * The plugin's minimum WordPress requirement
	 *
	 * @var string
	 */
	const MIN_WP_VERSION = '3.5';

	/**
	 * Configuration array
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Menu ID
	 *
	 * @var int
	 */
	protected $menu_id;

	/**
	 * Post Meta Model Instance
	 *
	 * @var I_Model
	 */
	protected $postmeta;

	/**
	 * User Meta Model Instance
	 *
	 * @var I_Model
	 */
	protected $usermeta;

	/**
	 * User's capability
	 *
	 * @var string
	 */
	protected $capability = 'manage_options';

	/*************************
	 * Getters
	 ************************/

	public function version() {
		return self::VERSION;
	}

	public function min_wp_version() {
		return self::MIN_WP_VERSION;
	}

	/*************************
	 * Instantiate & Init
	 ************************/

	/**
	 * Instantiate the plugin
	 *
	 * @since 1.0.1
	 *
	 * @param array     $config     Configuration array
	 * @param I_Model   $postmeta   Instance of post meta model
	 * @param I_Model   $usermeta   Instance of user meta model
	 * @param string    $capability User capability
	 * @return self
	 */
	public function __construct( array $config, I_Model $postmeta, I_Model $usermeta, $capability ) {
		$this->config       = $config;
		$this->postmeta     = $postmeta;
		$this->usermeta     = $usermeta;
		$this->capability   = $capability;

		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	protected function init_hooks() {

		add_action( 'plugins_loaded',           array( $this, 'load_textdomain' ) );

		add_action( 'admin_menu',               array( $this, 'add_menu_menu' ) );

		add_action( 'admin_enqueue_scripts',    array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Add the menu page to the Tools Menu
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function add_menu_menu() {
		$this->menu_id = add_management_page(
			__( 'Cleanup Duplicate Meta', 'cleanup_dup_meta' ),
			__( 'Cleanup Duplicates', 'cleanup_dup_meta' ),
			$this->capability,
			'cleanup_dup_meta',
			array( $this, 'render_menu_page' )
		);
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @param string    $hook       Current page
	 * @return null
	 */
	public function enqueue_scripts( $hook ) {

		if ( 'tools_page_cleanup_dup_meta' !== $hook ) {
			return;
		}

		wp_enqueue_style(
			'cleanup_dup_meta_css',
			CLEANUP_DUP_META_PLUGIN_URL . 'assets/build/plugin.min.css',
			array(),
			self::VERSION
		);

		wp_enqueue_script(
			'cleanup_dup_meta_js',
			CLEANUP_DUP_META_PLUGIN_URL . 'assets/build/jquery.plugin.min.js',
			array( 'jquery' ),
			self::VERSION,
			true
		);

		// Pass some parameters to javascript
		$params = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		);
		wp_localize_script( 'cleanup_dup_meta_js', 'cleanup_dup_meta_params', $params );
	}

	/**
	 * Render the Utility Page
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function render_menu_page() {

		/** @noinspection PhpIncludeInspection */
		include( $this->config['view'] );

		$this->postmeta->render();
		$this->usermeta->render();
	}

	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 *
	 * @return null
	 */
	public function load_textdomain() {
		load_plugin_textdomain(
			'cleanup_dup_meta',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}
}