<?php
App::uses('AppModel','Model');

class Prison extends AppModel{
    public $belongsTo = array(
        'Mastersecurity' => array(
            'className' => 'Mastersecurity',
            'foreignKey' => 'security_id',
            'conditions' => '',
            'fields' => array("Mastersecurity.name"),
            'order' => ''
        ),
        'Stationcategory' => array(
            'className' => 'Stationcategory',
            'foreignKey' => 'stationcategory_id',
            'conditions' => '',
            'fields' => array("Stationcategory.name"),
            'order' => ''
        ),
        'Magisterial' => array(
            'className' => 'Magisterial',
            'foreignKey' => 'magisterial_id',
            'conditions' => '',
            'order' => ''
        ),
    );
    public $validate=array(
        'name'=>array(
            'notBlank'=>array(
                'rule'=>'notBlank',
                'message'=>'Station Name is required !'
            ),
        ),
        'code'=>array(
            'isUnique'=>array(
                'rule'=>'isUnique',
                'message'=>'Station Code already exists !'
            )
        )
    );

}
?>