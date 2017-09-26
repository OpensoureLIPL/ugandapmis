<?php
App::uses('AppModel', 'Model');
class ShiftDeployment extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'shift_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=>'Select Shift'
			),
		),
		'force_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=>'Select Force'
			),
		),
		'shift_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=>'Select Date'
			),
		),
	);
	public $belongsTo = array(
		'Shift' => array(
			'className' => 'Shift',
			'foreignKey' => 'shift_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Officer' => array(
			'className' => 'Officer',
			'foreignKey' => 'force_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
