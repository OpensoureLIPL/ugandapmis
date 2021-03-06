<?php
App::uses('AppModel', 'Model');
class Visitor extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'date';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
}
