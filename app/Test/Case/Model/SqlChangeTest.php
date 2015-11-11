<?php
App::uses('SqlChange', 'Model');

/**
 * SqlChange Test Case
 *
 */
class SqlChangeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sql_change'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SqlChange = ClassRegistry::init('SqlChange');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SqlChange);

		parent::tearDown();
	}

}
