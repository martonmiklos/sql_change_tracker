<?php
App::uses('AppModel', 'Model');
/**
 * Rollout Model
 *
 * @property System $System
 * @property StartChange $StartChange
 * @property EndChange $EndChange
 */
class Rollout extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'System' => array(
			'className' => 'System',
			'foreignKey' => 'system_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StartChange' => array(
			'className' => 'SqlChange',
			'foreignKey' => 'start_change_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EndChange' => array(
			'className' => 'SqlChange',
			'foreignKey' => 'end_change_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
