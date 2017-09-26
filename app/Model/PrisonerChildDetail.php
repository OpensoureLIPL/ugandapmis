<?php
App::uses('AppModel','Model');

class PrisonerChildDetail extends AppModel{
	
   public $belongsTo = array(
        'Gender' => array(
            'className'     => 'Gender',
            'foreignKey'    => 'gender_id',
        ),  
    );

    public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'First Name is required !',
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
