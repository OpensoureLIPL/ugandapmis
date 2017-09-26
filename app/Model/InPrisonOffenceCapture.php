<?php
App::uses('AppModel', 'Model');
class InPrisonOffenceCapture extends AppModel {
	//public $hasOne = 'EarningGrade';
	public $belongsTo = array(
        'InternalOffence' => array(
            'className' => 'InternalOffence',
            'foreignKey' => 'internal_offence_id',
        ),
        
    );

	public $validate = array(
		'internal_offence_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Offence name is required.'
			 ),
			),
		'offence_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Offence Date is required.'
			),
			),
		
	);
}
