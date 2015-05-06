<?php namespace Cleanup_Dup_Meta\Tests\Models;

use Cleanup_Dup_Meta\Tests\Plugin_UnitTestCase;
use Cleanup_Dup_Meta\Models\Model;

class Test_Usermeta_Model extends Plugin_UnitTestCase {

	protected $model;

	function setUp() {
		parent::setUp();

		$this->model = new Model( include( CLEANUP_DUP_META_TESTS_DIR . '../lib/config/usermeta.php' ) );
	}

	function tearDown() {
		parent::tearDown();

		$this->model = null;
	}

	function test_config() {
		$config = $this->model->get( 'config' );

		$this->assertTrue( is_array( $config ) );
		$this->assertNotEmpty( $config );
	}

	function test_getter() {
		$this->assertEquals( 'usermeta', $this->model->get( 'type' ) );
		$this->assertEquals( '_cleanup_duplicates_usermeta', $this->model->get( 'nonce' ) );
		$this->assertEquals( array(
			'primary_id'    => 'umeta_id',
			'id'            => 'user_id',
		), $this->model->get( 'columns' ) );
	}
}