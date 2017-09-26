<?php
App::uses('AppModel', 'Model');
class Prisonerinout extends AppModel {
public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'gate_keeper_id',
        ),
        'Prisoner' => array(
            'className' => 'Prisoner',
            'foreignKey' => 'prisoner_no',
        ),
    );

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
}
