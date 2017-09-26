<?php
App::uses('AppModel', 'Model');
class PhysicalLockup extends AppModel {

	public $belongsTo = array(
        'LockupType' => array(
            'className' => 'LockupType',
            'foreignKey' => 'lockup_type_id',
        ),
        'PrisonerType' => array(
            'className' => 'PrisonerType',
            'foreignKey' => 'prisoner_type_id',
        ),
        
    );

	public $validate = array(
		'lockup_type_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Lock up type name is required.'
			 ),
			),
		'prisoner_type_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Prisoner type is required.'
			),
			),
		'no_of_male' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'No of Male  required.'
			),
			),
		'no_of_female' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'No of female is required.'
			),
		),	
	);
}
