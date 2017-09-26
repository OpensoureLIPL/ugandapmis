<?php
App::uses('AppController', 'Controller');
class MedicalRecordsController  extends AppController {
	public $layout='table';
	public $uses=array('Prisoner','MedicalSickRecord', 'Disease', 'Hospital', 'MedicalSeriousIllRecord', 'MedicalDeathRecord','MedicalCheckupRecord','User');	
	public function index() {
		$this->loadModel('MedicalRecord'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        /*if(isset($this->data['PrisonercomplaintDelete']['id']) && (int)$this->data['PrisonercomplaintDelete']['id'] != 0){
        	
                 $this->MedicalRecord->id=$this->data['PrisonercomplaintDelete']['id'];
                 $this->MedicalRecord->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }*/
    }
   
	public function add($uuidParam) { 
		if($uuidParam){
			$uuidAr 	= explode('#', $uuidParam);
			$uuid   	= $uuidAr[0];
			/*
			 *Query for get the prisoner details
			 */
			$prisonerdata = $this->Prisoner->find('first', array(
				'recursive'		=> -1,
				'conditions'	=> array(
					'Prisoner.uuid'	=> $uuid,
				),
			));
			if(isset($prisonerdata['Prisoner']['id']) && (int)$prisonerdata['Prisoner']['id'] != 0){ 
				$prisoner_id = $prisonerdata['Prisoner']['id'];
				/*
				 *Code start for insert and update the data of medical check up records
				 */
				if(isset($this->data['MedicalCheckupRecord']) && is_array($this->data['MedicalCheckupRecord']) && count($this->data['MedicalCheckupRecord'])>0){	
					if(isset($this->data['MedicalCheckupRecord']['uuid']) && $this->data['MedicalCheckupRecord']['uuid'] == ''){
						$uuidArr = $this->MedicalCheckupRecord->query("select uuid() as code");
						$this->request->data['MedicalCheckupRecord']['uuid'] = $uuidArr[0][0]['code'];	
					}
					if(isset($this->data['MedicalCheckupRecord']['checkup_date_time']) && $this->data['MedicalCheckupRecord']['checkup_date_time'] != ''){
						$this->request->data['MedicalCheckupRecord']['checkup_date_time'] = date('Y-m-d', strtotime($this->data['MedicalCheckupRecord']['checkup_date_time']));
					}				
					if($this->MedicalCheckupRecord->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');						
						//$this->redirect(array('controller'=>'medicalRecords', 'action' => 'add', $uuid.'#sick'));
						$this->redirect('/medicalRecords/add/'.$uuid.'#health_checkup');
					}else{
						//debug($this->MedicalSickRecord->validationErrors);
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the medical medical check up records
				*/
		        if(isset($this->data['MedicalCheckupRecordEdit']['id']) && (int)$this->data['MedicalCheckupRecordEdit']['id'] != 0){
		            if($this->MedicalCheckupRecord->exists($this->data['MedicalCheckupRecordEdit']['id'])){
		                $this->data = $this->MedicalCheckupRecord->findById($this->data['MedicalCheckupRecordEdit']['id']);
		            }
		        }
				/*
				 *Code start for insert and update the data of medical sick records
				 */
				if(isset($this->data['MedicalSickRecord']) && is_array($this->data['MedicalSickRecord']) && count($this->data['MedicalSickRecord'])>0){	
					if(isset($this->data['MedicalSickRecord']['uuid']) && $this->data['MedicalSickRecord']['uuid'] == ''){
						$uuidArr = $this->MedicalSickRecord->query("select uuid() as code");
						$this->request->data['MedicalSickRecord']['uuid'] = $uuidArr[0][0]['code'];	
					}
					if(isset($this->data['MedicalSickRecord']['check_up_date']) && $this->data['MedicalSickRecord']['check_up_date'] != ''){
						$this->request->data['MedicalSickRecord']['check_up_date'] = date('Y-m-d', strtotime($this->data['MedicalSickRecord']['check_up_date']));
					}				
					if($this->MedicalSickRecord->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');						
						//$this->redirect(array('controller'=>'medicalRecords', 'action' => 'add', $uuid.'#sick'));
						$this->redirect('/medicalRecords/add/'.$uuid.'#sick');
					}else{
						//debug($this->MedicalSickRecord->validationErrors);
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the medical sick records
				*/
		        if(isset($this->data['MedicalSickRecordEdit']['id']) && (int)$this->data['MedicalSickRecordEdit']['id'] != 0){
		            if($this->MedicalSickRecord->exists($this->data['MedicalSickRecordEdit']['id'])){
		                $this->data = $this->MedicalSickRecord->findById($this->data['MedicalSickRecordEdit']['id']);
		            }
		        }
		        /*
		         *Code for insert and update the data of medical serious ill records
		         */
				if(isset($this->data['MedicalSeriousIllRecord']) && is_array($this->data['MedicalSeriousIllRecord']) && count($this->data['MedicalSeriousIllRecord'])>0){	
					if(isset($this->data['MedicalSeriousIllRecord']['uuid']) && $this->data['MedicalSeriousIllRecord']['uuid'] == ''){
						$uuidArr = $this->MedicalSeriousIllRecord->query("select uuid() as code");
						$this->request->data['MedicalSeriousIllRecord']['uuid'] = $uuidArr[0][0]['code'];
					}	
					if(isset($this->data['MedicalSeriousIllRecord']['check_up_date']) && $this->data['MedicalSeriousIllRecord']['check_up_date'] != ''){
						$this->request->data['MedicalSeriousIllRecord']['check_up_date'] = date('Y-m-d', strtotime($this->data['MedicalSeriousIllRecord']['check_up_date']));
					}				
					if($this->MedicalSeriousIllRecord->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');						
						//$this->redirect(array('controller'=>'medicalRecords', 'action' => 'add', $uuid.'#sick'));
						$this->redirect('/medicalRecords/add/'.$uuid.'#seriouslyill');
					}else{
						//debug($this->MedicalSickRecord->validationErrors);
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the medical serious ill records
				*/				
		        if(isset($this->data['MedicalSeriousIllRecordEdit']['id']) && (int)$this->data['MedicalSeriousIllRecordEdit']['id'] != 0){
		            if($this->MedicalSeriousIllRecord->exists($this->data['MedicalSeriousIllRecordEdit']['id'])){
		                $this->data = $this->MedicalSeriousIllRecord->findById($this->data['MedicalSeriousIllRecordEdit']['id']);
		            }
		        }
				/*
		         *Code for insert and update the data of medical death records
		         */
				if(isset($this->data['MedicalDeathRecord']) && is_array($this->data['MedicalDeathRecord']) && count($this->data['MedicalDeathRecord'])>0){	
					if(isset($this->data['MedicalDeathRecord']['uuid']) && $this->data['MedicalDeathRecord']['uuid'] == ''){
						$uuidArr = $this->MedicalDeathRecord->query("select uuid() as code");
						$this->request->data['MedicalDeathRecord']['uuid'] = $uuidArr[0][0]['code'];	
					}
					if(isset($this->data['MedicalDeathRecord']['check_up_date']) && $this->data['MedicalDeathRecord']['check_up_date'] != ''){
						$this->request->data['MedicalDeathRecord']['check_up_date'] = date('Y-m-d', strtotime($this->data['MedicalDeathRecord']['check_up_date']));
					}				
					if($this->MedicalDeathRecord->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');						
						//$this->redirect(array('controller'=>'medicalRecords', 'action' => 'add', $uuid.'#sick'));
						$this->redirect('/medicalRecords/add/'.$uuid.'#death');
					}else{
						//debug($this->MedicalSickRecord->validationErrors);
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the medical death records
				*/				
		        if(isset($this->data['MedicalDeathRecordEdit']['id']) && (int)$this->data['MedicalDeathRecordEdit']['id'] != 0){
		            if($this->MedicalDeathRecord->exists($this->data['MedicalDeathRecordEdit']['id'])){
		                $this->data = $this->MedicalDeathRecord->findById($this->data['MedicalDeathRecordEdit']['id']);
		            }
		        }		        
		        /*
		         *Query for get the disease list
		         */
		        $diseaseList = $this->Disease->find('list', array(
		        	'recursive'		=> -1,
		        	'fields'		=> array(
		        		'Disease.id',
		        		'Disease.name',
		        	),
		        	'conditions'	=> array(
		        		'Disease.is_enable'		=> 1,
		        		'Disease.is_trash'		=> 0
		        	),
		        	'order'			=> array(
		        		'Disease.name'
		        	),
		        ));
		        /*
		         *Query for get the hospital List
		         */
		        $hospitalList = $this->Hospital->find('list', array(
		        	'recursive'		=> -1,
		        	'fields'		=> array(
		        		'Hospital.id',
		        		'Hospital.name'
		        	),
		        	'conditions'	=> array(
		        		'Hospital.is_enable'	=> 1,
		        		'Hospital.is_trash'		=> 0,
		        	),
		        	'order'			=> array(
		        		'Hospital.name'	
		        	),
		        ));
		         $medicalOfficers=$this->User->find('list',array(
                'fields'        => array(
                    'User.id',
                    'User.first_name',
                ),
                'conditions'=>array(
                  'User.is_enable'=>1,
                  'User.is_trash'=>0,
                  'User.usertype_id'=>6	,//Gate keeper User
                ),
                'order'=>array(
                  'User.first_name'
                )
          ));

		        $this->set(array(
		        	'uuid'				=> $uuid,
		        	'prisoner_id'		=> $prisoner_id,
		        	'diseaseList'		=> $diseaseList,
		        	'hospitalList'		=> $hospitalList,
		        	'prisoner_id' 		=> $prisonerdata['Prisoner']['id'],
                    'uuid' 				=> $prisonerdata['Prisoner']['uuid'],
                    'medicalOfficers'	=> $medicalOfficers,
		        ));
			}else{
				return $this->redirect(array('action' => 'index'));				
			}
    	}else{
    		return $this->redirect(array('action' => 'index'));
    	}
	}
	//Medical Health check up
	public function medicalCheckupData(){
		$this->layout = 'ajax';
		if(isset($this->params['named']['prisoner_id']) && (int)$this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
			$prisoner_id 	= $this->params['named']['prisoner_id'];
			$uuid 			= $this->params['named']['uuid'];
			$condition 		= array(
				'MedicalCheckupRecord.prisoner_id'		=> $prisoner_id,
				'MedicalCheckupRecord.is_trash'		=> 0,
			);
			if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
	            if($this->params['named']['reqType']=='XLS'){
	                $this->layout='export_xls';
	                $this->set('file_type','xls');
	                $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.xls');
	            }else if($this->params['named']['reqType']=='DOC'){
	                $this->layout='export_xls';
	                $this->set('file_type','doc');
	                $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.doc');
	            }
	            $this->set('is_excel','Y');         
	            $limit = array('limit' => 2000,'maxLimit'   => 2000);
	        }else{
	            $limit = array('limit'  => 20);
	        } 			
			$this->paginate = array(
				'conditions'	=> $condition,
				'order'			=> array(
					'MedicalCheckupRecord.modified'	=> 'DESC',
				),
			)+$limit;
			$datas = $this->paginate('MedicalCheckupRecord');
			$this->set(array(
				'datas'			=> $datas,
				'prisoner_id'	=> $prisoner_id,
				'uuid'			=> $uuid,
			));
		}
	}
	public function deleteMedicalCheckupRecords(){
		$this->autoRender = false;
		if(isset($this->data['paramId'])){
			$uuid = $this->data['paramId'];
			$fields = array(
				'MedicalCheckupRecord.is_trash'	=> 1,
			);
			$conds = array(
				'MedicalCheckupRecord.uuid'	=> $uuid,
			);
			if($this->MedicalCheckupRecord->updateAll($fields, $conds)){
				echo 'SUCC';
			}else{
				echo 'FAIL';
			}
		}else{
			echo 'FAIL';
		}
	}
	public function medicalSickData(){
		$this->layout = 'ajax';
		if(isset($this->params['named']['prisoner_id']) && (int)$this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
			$prisoner_id 	= $this->params['named']['prisoner_id'];
			$uuid 			= $this->params['named']['uuid'];
			$condition 		= array(
				'MedicalSickRecord.prisoner_id'		=> $prisoner_id,
				'MedicalSickRecord.is_trash'		=> 0,
			);
			if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
	            if($this->params['named']['reqType']=='XLS'){
	                $this->layout='export_xls';
	                $this->set('file_type','xls');
	                $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.xls');
	            }else if($this->params['named']['reqType']=='DOC'){
	                $this->layout='export_xls';
	                $this->set('file_type','doc');
	                $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.doc');
	            }
	            $this->set('is_excel','Y');         
	            $limit = array('limit' => 2000,'maxLimit'   => 2000);
	        }else{
	            $limit = array('limit'  => 20);
	        } 			
			$this->paginate = array(
				'conditions'	=> $condition,
				'order'			=> array(
					'MedicalSickRecord.modified'	=> 'DESC',
				),
			)+$limit;
			$datas = $this->paginate('MedicalSickRecord');
			$this->set(array(
				'datas'			=> $datas,
				'prisoner_id'	=> $prisoner_id,
				'uuid'			=> $uuid,
			));
		}
	}
	public function deleteMedicalSickRecords(){
		$this->autoRender = false;
		if(isset($this->data['paramId'])){
			$uuid = $this->data['paramId'];
			$fields = array(
				'MedicalSickRecord.is_trash'	=> 1,
			);
			$conds = array(
				'MedicalSickRecord.uuid'	=> $uuid,
			);
			if($this->MedicalSickRecord->updateAll($fields, $conds)){
				echo 'SUCC';
			}else{
				echo 'FAIL';
			}
		}else{
			echo 'FAIL';
		}
	}
	public function showMedicalSeriousIllRecords(){
		$this->layout = 'ajax';
		if(isset($this->params['named']['prisoner_id']) && (int)$this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
			$prisoner_id 	= $this->params['named']['prisoner_id'];
			$uuid 			= $this->params['named']['uuid'];
			$condition 		= array(
				'MedicalSeriousIllRecord.prisoner_id'		=> $prisoner_id,
				'MedicalSeriousIllRecord.is_trash'		=> 0,
			);
			if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
	            if($this->params['named']['reqType']=='XLS'){
	                $this->layout='export_xls';
	                $this->set('file_type','xls');
	                $this->set('file_name','medical_seriousill_report_'.date('d_m_Y').'.xls');
	            }else if($this->params['named']['reqType']=='DOC'){
	                $this->layout='export_xls';
	                $this->set('file_type','doc');
	                $this->set('file_name','medical_seriousill_report_'.date('d_m_Y').'.doc');
	            }
	            $this->set('is_excel','Y');         
	            $limit = array('limit' => 2000,'maxLimit'   => 2000);
	        }else{
	            $limit = array('limit'  => 20);
	        } 			
			$this->paginate = array(
				'conditions'	=> $condition,
				'order'			=> array(
					'MedicalSeriousIllRecord.modified'	=> 'DESC',
				),
			)+$limit;
			$datas = $this->paginate('MedicalSeriousIllRecord');
			$this->set(array(
				'datas'			=> $datas,
				'prisoner_id'	=> $prisoner_id,
				'uuid'			=> $uuid,
			));
		}
	}
	public function deleteMedicalSeriousillRecords(){
		$this->autoRender = false;
		if(isset($this->data['paramId'])){
			$uuid = $this->data['paramId'];
			$fields = array(
				'MedicalSeriousIllRecord.is_trash'	=> 1,
			);
			$conds = array(
				'MedicalSeriousIllRecord.uuid'	=> $uuid,
			);
			if($this->MedicalSeriousIllRecord->updateAll($fields, $conds)){
				echo 'SUCC';
			}else{
				echo 'FAIL';
			}
		}else{
			echo 'FAIL';
		}
	}
	public function showMedicalDeathRecords(){
		$this->layout = 'ajax';
		if(isset($this->params['named']['prisoner_id']) && (int)$this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
			$prisoner_id 	= $this->params['named']['prisoner_id'];
			$uuid 			= $this->params['named']['uuid'];
			$condition 		= array(
				'MedicalDeathRecord.prisoner_id'		=> $prisoner_id,
				'MedicalDeathRecord.is_trash'		=> 0,
			);
			if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
	            if($this->params['named']['reqType']=='XLS'){
	                $this->layout='export_xls';
	                $this->set('file_type','xls');
	                $this->set('file_name','medical_death_report_'.date('d_m_Y').'.xls');
	            }else if($this->params['named']['reqType']=='DOC'){
	                $this->layout='export_xls';
	                $this->set('file_type','doc');
	                $this->set('file_name','medical_death_report_'.date('d_m_Y').'.doc');
	            }
	            $this->set('is_excel','Y');         
	            $limit = array('limit' => 2000,'maxLimit'   => 2000);
	        }else{
	            $limit = array('limit'  => 20);
	        } 			
			$this->paginate = array(
				'conditions'	=> $condition,
				'order'			=> array(
					'MedicalDeathRecord.modified'	=> 'DESC',
				),
			)+$limit;
			$datas = $this->paginate('MedicalDeathRecord');
			$this->set(array(
				'datas'			=> $datas,
				'prisoner_id'	=> $prisoner_id,
				'uuid'			=> $uuid,
			));
		}		
	}
	public function deleteMedicalDeathRecords(){
		$this->autoRender = false;
		if(isset($this->data['paramId'])){
			$uuid = $this->data['paramId'];
			$fields = array(
				'MedicalDeathRecord.is_trash'	=> 1,
			);
			$conds = array(
				'MedicalDeathRecord.uuid'	=> $uuid,
			);
			if($this->MedicalDeathRecord->updateAll($fields, $conds)){
				echo 'SUCC';
			}else{
				echo 'FAIL';
			}
		}else{
			echo 'FAIL';
		}		
	}	
}