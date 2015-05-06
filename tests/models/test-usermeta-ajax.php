<?php namespace Cleanup_Dup_Meta\Tests\Models;

/**
 * Admin ajax functions to be tested
 */
require_once( ABSPATH . 'wp-admin/includes/ajax-actions.php' );

use WP_Ajax_UnitTestCase;
use Cleanup_Dup_Meta\Models\Model;
use WPAjaxDieContinueException;

/**
 * Class Test_Usermeta_AJAX
 * @package Cleanup_Dup_Meta\Tests\Models
 * @group ajax
 */
class Test_Usermeta_AJAX extends WP_Ajax_UnitTestCase {

	protected $model;

	function setUp() {
		parent::setUp();

		$this->model = new Model( include( CLEANUP_DUP_META_TESTS_DIR . '../lib/config/usermeta.php' ) );
	}

	function tearDown() {
		parent::tearDown();

		$this->model = null;
	}

	function test_check_count_returns_zero_count() {
		$this->_setRole( 'administrator' );

		$action = 'count_duplicate_usermeta';

		$_POST['action']    = $action;
		$config = $this->model->get( 'config' );
		$_POST['security']  = wp_create_nonce( $config['nonce'] );

		try {
			$this->_handleAjax( $action );

		//* this is the excepted error
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$this->assertEquals( 0, $this->_last_response );
	}

	function test_check_count() {

		$this->insert_duplicates( 3 );

		$this->_setRole( 'administrator' );

		$action = 'count_duplicate_usermeta';
		$config = $this->model->get( 'config' );
		$_POST['security']  = wp_create_nonce( $config['nonce'] );
		$_POST['action']        = $action;

		try {
			$this->_handleAjax( $action );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$this->assertEquals( 2, $this->_last_response );
	}

	function test_cleanup() {
		$this->_setRole( 'administrator' );

		$action = 'cleanup_duplicate_usermeta';
		$config = $this->model->get( 'config' );

		$_POST['security']      = wp_create_nonce( $config['nonce'] );
		$_POST['action']        = $action;
		$_POST['keep_first']    = 'first';

		try {
			$this->_handleAjax( $action );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$this->assertEquals( 0, $this->_last_response );

		$this->insert_duplicates( 3 );

		try {
			$this->_handleAjax( $action );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$this->assertEquals( 2, $this->_last_response );
		$this->assertEquals( 1, get_user_meta( 1, '_foo', true ) );
	}

	function test_cleanup_keep_last() {
		$this->_setRole( 'administrator' );

		$action = 'cleanup_duplicate_usermeta';
		$config = $this->model->get( 'config' );

		$_POST['security']      = wp_create_nonce( $config['nonce'] );
		$_POST['action']        = $action;
		$_POST['keep_first']    = 'last';

		$this->insert_duplicates( 4 );

		try {
			$this->_handleAjax( $action );
		} catch ( WPAjaxDieContinueException $e ) {
			unset( $e );
		}

		$this->assertEquals( 3, $this->_last_response );
		$this->assertEquals( 4, get_user_meta( 1, '_foo', true ) );
	}


	/*****************
	 * Helpers
	 ****************/

	/**
	 * Insert duplicates into the Post Meta table
	 *
	 * @param int $num_dups
	 */
	protected function insert_duplicates( $num_dups = 2 ) {
		global $wpdb;
		for( $num = 0; $num < $num_dups; $num++ ) {
			$wpdb->insert(
				$wpdb->usermeta,
				array(
					'user_id'       => 1,
					'meta_key'      => '_foo',
					'meta_value'    => $num + 1,
				),
				array(
					'%d',
					'%s',
					'%s'
				)
			);
		}
	}
}