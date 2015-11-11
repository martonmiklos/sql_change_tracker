<?php
App::uses('AppModel', 'Model');
/**
 * System Model
 *
 * @property SqlChange $SqlChange
 * @property Application $Application
 * @property Rollout $Rollout
 */
class System extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SqlChange' => array(
			'className' => 'SqlChange',
			'foreignKey' => 'sql_change_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Application' => array(
			'className' => 'Application',
			'foreignKey' => 'application_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Rollout' => array(
			'className' => 'Rollout',
			'foreignKey' => 'system_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
