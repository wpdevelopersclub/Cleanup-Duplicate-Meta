<?php

/**
 * The path to the WordPress tests checkout.
 */
if ( ! defined( 'WP_TESTS_DIR' ) ) {
	define( 'WP_TESTS_DIR', '/Users/julie/sites/wordpress-develop/tests/phpunit/' );
//	define( 'WP_TESTS_VENDOR_DIR', '/Users/julie/sites/wordpress-develop/vendor/' );
}

// $_tests_dir = getenv('WP_TESTS_DIR');
$_tests_dir = WP_TESTS_DIR;
if ( ! $_tests_dir ) $_tests_dir = '/tmp/wordpress-tests-lib';

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	define( 'CLEANUP_DUP_META_TESTS_DIR', trailingslashit( __DIR__ ) );

	if ( ! defined( 'CLEANUP_DUP_META_PLUGIN_DIR' ) ) {
		define( 'CLEANUP_DUP_META_PLUGIN_DIR', CLEANUP_DUP_META_TESTS_DIR . '../' );
	}

	if ( ! defined( 'CLEANUP_DUP_META_PLUGIN_URL' ) ) {
		$url = str_replace( 'tests/', '', plugin_dir_url( __FILE__ ) );
		define( 'CLEANUP_DUP_META_PLUGIN_URL', $url );
	}

//	require CLEANUP_DUP_META_TESTS_DIR. '../plugin.php';
	require( CLEANUP_DUP_META_TESTS_DIR . '../assets/vendor/autoload.php' );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';
require( __DIR__ . '/plugin-unitestcase.php' );