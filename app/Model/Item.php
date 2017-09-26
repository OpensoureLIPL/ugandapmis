<?php
App::uses('AppModel', 'Model');
class Item extends AppModel {
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Name is required.'
			),
		),	
		'price' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Price is required.'
			),
		),
	);
}
