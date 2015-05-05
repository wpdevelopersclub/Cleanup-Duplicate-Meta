<?php namespace Cleanup_Dup_Meta\Tests;

use WP_UnitTestCase;

class Plugin_UnitTestCase extends WP_UnitTestCase {

	function setUp() {
		global $cleanup_dup_meta_debug;
		$cleanup_dup_meta_debug = false;

		parent::setUp();
	}


	function tearDown() {
		global $cleanup_dup_meta_debug;
		$cleanup_dup_meta_debug = false;

		parent::tearDown();
	}

	protected function die_handler( $handler ) {
		return __NAMESPACE__ . '\\wp_die_handler';
	}

}

/**********************************
 * Turn off die() during tests
 *********************************/

function wp_die_handler( $message, $title, $args ) {
	return $message;
}