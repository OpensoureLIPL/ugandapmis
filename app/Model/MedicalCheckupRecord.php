<?php
App::uses('AppModel', 'Model');
class MedicalCheckupRecord extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'medical_officer_id',
        ), 

    );    
	public $validate = array(
		'checkup_date_time' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Check up date time is required !',
			),
		),
		'medical_officer_id' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Medical Officer is required !',
			),
		),
		'check_up_details' 	=> array(
			'notBlank' 		=> array(
				'rule' 		=> array('notBlank'),
				'message' 	=> 'Checkup Detail is required !',
			),
		),
		'supported_files' 	=> array(
            'rule1'=>array(
                'rule'    => 'validateEmptyPhoto',
                'message' => 'Please supported file'
            ),        
            'rule2'=>array(
                'rule'    => 'validateExtPhoto',
                'message' => 'Please upload (jpg,jpeg,png,gif,pdf) type file'
            ),
            'rule3'=>array(
                'rule'    => 'validateSizePhoto',
                'message' => 'Please upload valid file'
            ),  
		),						
	);
	public function beforeSave($options = Array()) {
        if(isset($this->data['MedicalCheckupRecord']['supported_files']['tmp_name']) && $this->data['MedicalCheckupRecord']['supported_files']['tmp_name'] != '' && (int)$this->data['MedicalCheckupRecord']['supported_files']['size'] > 0){
            $ext        = $this->getExt($this->data['MedicalCheckupRecord']['supported_files']['name']);
            $softName       = 'attachment_'.rand().'_'.time().'.'.$ext;
            $pathName       = './files/prisnors/MEDICAL/'.$softName;
            if(move_uploaded_file($this->data['MedicalCheckupRecord']['supported_files']['tmp_name'],$pathName)){
                unset($this->data['MedicalCheckupRecord']['supported_files']);
                $this->data['MedicalCheckupRecord']['supported_files'] = $softName;
            }else{
                return false;
            }
        }else{
            unset($this->data['MedicalCheckupRecord']['supported_files']);
        }
    }
    public function validateEmptyPhoto(){
        if(isset($this->data['MedicalSickRecord']['supported_files']['tmp_name']) && $this->data['MedicalSickRecord']['supported_files']['tmp_name'] == '' && $this->data['MedicalSickRecord']['id'] == ''){
            return false;
        }else{
            return true;
        }       
    } 
    public function validateExtPhoto(){ 
        if(isset($this->data['MedicalCheckupRecord']['supported_files']['tmp_name']) && $this->data['MedicalCheckupRecord']['supported_files']['tmp_name'] != '' && (int)$this->data['MedicalCheckupRecord']['supported_files']['size'] > 0){
            $fileExt            = $this->getExt($this->data['MedicalCheckupRecord']['supported_files']['name']);
            if(strtolower($fileExt) != 'jpg' && strtolower($fileExt) != 'jpeg' && strtolower($fileExt) != 'png' && strtolower($fileExt) != 'gif' && strtolower($fileExt) != 'pdf'){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }   
    }
    public function validateSizePhoto(){
        if(isset($this->data['MedicalCheckupRecord']['supported_files']['tmp_name']) && $this->data['MedicalCheckupRecord']['supported_files']['tmp_name'] != ''){
            $fileSize    = $this->data['MedicalCheckupRecord']['supported_files']['size'];
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
