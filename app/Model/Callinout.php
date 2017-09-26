<?php
App::uses('AppModel', 'Model');
class Callinout extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'date';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'call_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Select Date',
			),
		),
		'prisoner_no' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Select Prisoner Number',
			),
		),
		'from' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Enter From',
			),
		),
		'to' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Enter To',
			),
		),
		'delivered_by' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Enter Delivered By',
			),
		)
	);
}
