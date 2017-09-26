<?php
App::uses('AppModel', 'Model');
class StagePromotion extends AppModel {
	//public $hasOne = 'EarningGrade';
	public $belongsTo = array(
        'Stage_New' => array(
            'className' => 'Stage',
            'foreignKey' => 'new_stage_id',
        ),
        'Stage_Old' => array(
            'className' => 'Stage',
            'foreignKey' => 'old_stage_id',
        ),
        
    );

	public $validate = array(
		'new_stage_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Stage Name is required.'
			 ),
			),
		'promotion_date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message'=> 'Promotion Date is required.'
			),
			),
		
	);
}
