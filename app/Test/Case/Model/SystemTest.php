<?php
App::uses('System', 'Model');

/**
 * System Test Case
 *
 */
class SystemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.system',
		'app.changes_version',
		'app.application',
		'app.rollout'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->System = ClassRegistry::init('System');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->System);

		parent::tearDown();
	}

}
