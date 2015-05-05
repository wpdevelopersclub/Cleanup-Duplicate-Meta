<?php namespace Cleanup_Dup_Meta\Tests\Models;

use Cleanup_Dup_Meta\Tests\Plugin_UnitTestCase;
use Cleanup_Dup_Meta\Models\Post_Meta;

class Test_Postmeta extends Plugin_UnitTestCase {

	protected $model;

	function setUp() {
		parent::setUp();

		$this->model = new Post_Meta( include( CLEANUP_DUP_META_TESTS_DIR . '../lib/config/postmeta.php' ) );
	}

	function tearDown() {
		parent::tearDown();

		$this->model = null;
	}

	function test_config() {
		$config = $this->model->get( 'config' );

		$this->assertTrue( is_array( $config ) );
		$this->assertNotEmpty( $config );
		$this->assertEquals( 'postmeta', $config['table'] );
		$this->assertEquals( '_cleanup_duplicate_postmeta', $config['nonce'] );

		$this->assertEquals( 'postmeta', $this->model->get( 'table' ) );
	}

	function test_ajax_error_for_nonce() {
		$this->setExpectedException( 'WPDieException' );
		$this->model->ajax_count();
	}

	function test_check_count_returns_0() {
		$config = $this->model->get( 'config' );
		$_REQUEST = array (
			'security' => wp_create_nonce( $config['nonce'] ),
		);

		ob_start();
		$this->model->ajax_count();

		$this->assertEquals( 0, ob_get_clean() );
	}

	function test_check_count() {

		$this->insert_duplicates( 3 );

		$config = $this->model->get( 'config' );
		$_REQUEST = array (
			'security' => wp_create_nonce( $config['nonce'] ),
		);

		ob_start();
		$this->model->ajax_count();

		$this->assertEquals( 2, ob_get_clean() );
	}

	function test_cleanup() {
		$config = $this->model->get( 'config' );
		$_REQUEST = array (
			'security'      => wp_create_nonce( $config['nonce'] ),
			'keep_first'    => 'first',
		);

		ob_start();
		$this->model->ajax_cleanup();
		$this->assertEquals( 0, ob_get_clean() );

		$this->insert_duplicates( 3 );

		ob_start();
		$this->model->ajax_cleanup();
		$this->assertEquals( 2, ob_get_clean() );
		$this->assertEquals( 1, get_post_meta( 1, '_foo', true ) );

		$_REQUEST = array (
			'security'      => wp_create_nonce( $config['nonce'] ),
			'keep_first'    => 'first',
		);
	}

	function test_cleanup_keep_last() {
		$config = $this->model->get( 'config' );
		$_REQUEST = array (
			'security'      => wp_create_nonce( $config['nonce'] ),
			'keep_first'    => '',
		);

		$this->insert_duplicates( 3 );

		ob_start();
		$this->model->ajax_cleanup();
		$this->assertEquals( 2, ob_get_clean() );
		$this->assertEquals( 3, get_post_meta( 1, '_foo', true ) );
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
				$wpdb->postmeta,
				array(
					'post_id'       => 1,
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