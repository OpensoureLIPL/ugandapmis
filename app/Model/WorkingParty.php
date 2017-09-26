<?php
App::uses('AppModel', 'Model');
class WorkingParty extends AppModel {
	public $validate = array(
		'start_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Start date is required.'
			),
		),	
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Name of working party is required.'
			),
		),
	);
}
