<?php
App::uses('AppModel','Model');

class PrisonerKinDetail extends AppModel{
	
   public $belongsTo = array(
        'Gender' => array(
            'className'     => 'Gender',
            'foreignKey'    => 'gender_id',
        ),  
    );

    public $validate = array(
		'first_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'First Name is required !',
			),
		),	
		'last_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'surname is required !',
			),
		),			
		'gender_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Gender is required !',
			),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Gender should be numeric !',
            ),            
		),	
          										
	);
}
