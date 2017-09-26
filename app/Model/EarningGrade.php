<?php
App::uses('AppModel', 'Model');
class EarningGrade extends AppModel {
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Earning grade name is required.'
			),
		),	
	);
}
