<?php
App::uses('AppModel', 'Model');
class RecordFood extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'date';
/**
 * Validation rules
 *
 * @var array
 */
 	public $belongsTo = array(
        'Prison' => array(
            'className' 	=> 'Prison',
            'foreignKey' 	=> 'prison_station_name',
        )
        
    );
	public $validate = array(
		'date' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
}
