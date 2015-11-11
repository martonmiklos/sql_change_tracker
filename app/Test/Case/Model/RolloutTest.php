<?php
App::uses('Rollout', 'Model');

/**
 * Rollout Test Case
 *
 */
class RolloutTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.rollout',
		'app.system',
		'app.sql_change',
		'app.application',
		'app.start_change',
		'app.end_change'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Rollout = ClassRegistry::init('Rollout');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Rollout);

		parent::tearDown();
	}

}
