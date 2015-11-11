<?php
/**
 * RolloutFixture
 *
 */
class RolloutFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'system_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'start_change_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'end_change_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
		'rolled_out' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_rollouts_1_idx' => array('column' => 'system_id', 'unique' => 0),
			'fk_rollouts_3_idx' => array('column' => 'end_change_id', 'unique' => 0),
			'fk_rollouts_2_idx' => array('column' => 'start_change_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'system_id' => 1,
			'start_change_id' => 1,
			'end_change_id' => 1,
			'rolled_out' => 1,
			'date' => '2014-05-11 11:31:32'
		),
	);

}
