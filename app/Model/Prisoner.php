<?php
App::uses('AppModel','Model');

class Prisoner extends AppModel{
    public $belongsTo = array(
        'Prison' => array(
            'className' 	=> 'Prison',
            'foreignKey' 	=> 'prison_id',
        ),
        'Gender' => array(
            'className'     => 'Gender',
            'foreignKey'    => 'gender_id',
        ),
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
        ),
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
        ),
        'District' => array(
            'className' => 'District',
            'foreignKey' => 'district_id',
        ), 
        
    );
	public $virtualFields = array(
		'fullname' => 'CONCAT(Prisoner.first_name, " ", Prisoner.last_name)'
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
		'father_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Father name is required !',
			),
		),
		'mother_name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Mother name is required !',
			),
		),
		'date_of_birth' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Date of is required !',
			),
		),
		'place_of_birth' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Place of is required !',
			),
		),
		'place_of_birth' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Place of is required !',
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
		'country_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Country is required !',
			),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Country should be numeric !',
            ),            
		),
        'state_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Region is required !',
            ),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Region should be numeric !',
            ),            
        ),
		'tribe_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Tribe is required !',
			),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Tribe should be numeric !',
            ),            
		),	
        'classification_id' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '  Classification is required !',
            ),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Classification should be numeric !',
            ),            
        ),  													
        'photo'=>array(
            'rule1'=>array(
                'rule'    => 'validateEmptyPhoto',
                'message' => 'Please Upload Photo'
            ),        
            'rule2'=>array(
                'rule'    => 'validateExtPhoto',
                'message' => 'Please upload (jpg,jpeg,png,gif) type photo'
            ),
            'rule3'=>array(
                'rule'    => 'validateSizePhoto',
                'message' => 'Please upload valid photo'
            ),  
        ),	
        'id_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Id proof is required !',
            ),
            'rule1' => array(
                'rule' => array('numeric'),
                'message' => 'Id proof should be numeric !',
            ),            
        ),  
        'id_number' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => 'Id proof number is required !',
            )         
        ),  										
	);
    
	public function beforeSave($options = Array()) {

       //echo '<pre>'; print_r($this->data); exit;

        if(isset($this->data['Prisoner']['photo']) && is_array($this->data['Prisoner']['photo']))
        {
            if(isset($this->data['Prisoner']['photo']['tmp_name']) && $this->data['Prisoner']['photo']['tmp_name'] != '' && (int)$this->data['Prisoner']['photo']['size'] > 0){
                $ext        = $this->getExt($this->data['Prisoner']['photo']['name']);
                $softName       = 'profilephoto_'.rand().'_'.time().'.'.$ext;
                $pathName       = './files/prisnors/'.$softName;
                if(move_uploaded_file($this->data['Prisoner']['photo']['tmp_name'],$pathName)){
                    unset($this->data['Prisoner']['photo']);
                    $this->data['Prisoner']['photo'] = $softName;
                }else{
                    return false;
                }
            }else{
                unset($this->data['Prisoner']['photo']);
            }
        }
        
    }
    public function validateEmptyPhoto(){

        if(isset($this->data['Prisoner']['photo']) && is_string($this->data['Prisoner']['photo']))
        {
            return true;
        }
        if(isset($this->data['Prisoner']['photo']['tmp_name'])){
            if($this->data['Prisoner']['photo']['tmp_name'] == '')
                return false;
            else
                return true;
        }else{
            return true;
        }       
    } 
    public function validateExtPhoto(){ 
        
        if(isset($this->data['Prisoner']['photo']['tmp_name']) && $this->data['Prisoner']['photo']['tmp_name'] != '' && (int)$this->data['Prisoner']['photo']['size'] > 0){
            $fileExt            = $this->getExt($this->data['Prisoner']['photo']['name']);
            if(strtolower($fileExt) != 'jpg' && strtolower($fileExt) != 'jpeg' && strtolower($fileExt) != 'png' && strtolower($fileExt) != 'gif'){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }   
    }
    public function validateSizePhoto(){
        if(isset($this->data['Prisoner']['photo']['tmp_name']) && $this->data['Prisoner']['photo']['tmp_name'] != ''){
            $fileSize    = $this->data['Prisoner']['photo']['size'];
            if($fileSize == 0){
                return false;
            }else{
                return true;
            }
            /*if($drawingfileSize > 2097152){
                $errorCnt++;
                $this->BoqEstimation->validationErrors['est_drawing'][] = 'Exceeding file size limit.Please upload file within 2Mb in size.';
            }*/
        }else{
            return true;
        }       
    } 	    
}
?>