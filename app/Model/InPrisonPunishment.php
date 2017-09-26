<?php
App::uses('AppModel', 'Model');
class InPrisonPunishment extends AppModel {
	//public $hasOne = 'EarningGrade';
	public $belongsTo = array(
        'InternalPunishment' => array(
            'className' => 'InternalPunishment',
            'foreignKey' => 'internal_punishment_id',
        ),
        
        'InPrisonOffenceCapture' => array(
            'className' => 'InPrisonOffenceCapture',
            'foreignKey' => 'in_prison_offence_id',
        ),
        
   
    );

	public $validate = array(
		'in_prison_offence_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Offence name is required.'
			 ),
			),
		'internal_punishment_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Offence Date is required.'
			),
			),
		'punishment_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Offence Date is required.'
			),
			),

		
	);
}
