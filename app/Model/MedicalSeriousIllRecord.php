<?php
App::uses('AppModel', 'Model');
class MedicalSeriousIllRecord extends AppModel {
    public $belongsTo = array(
        'Disease' => array(
            'className'     => 'Disease',
            'foreignKey'    => 'disease_id',
        ),
        'Hospital' => array(
            'className'     => 'Hospital',
            'foreignKey'    => 'hospital_id',
        ),           
    );    
	public $validate = array(
		'check_up_date' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Check up date is required !',
			),
		),
		'disease_id' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Disease is required !',
			),
		),
		'hospital_id' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Hospital is required !',
			),
		),					
	);
}
