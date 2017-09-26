<?php
App::uses('AppController', 'Controller');
class DischargesController    extends AppController {
	public $layout='table';
	public $uses=array('Prisoner', 'Discharge', 'DischargeType','GatePass','DeathInCustody', 'DischargeEscape','PrisonerSentenceDetail');
	public function index($uuid) {
		if($uuid){
			/*
			 *Query for validate uuid of priosners
			 */
			$prisonerData = $this->Prisoner->find('first', array(
				'recursive'		=> -1,
				'conditions'	=> array(
					'Prisoner.uuid'		=> $uuid,
				),
			));
			if(isset($prisonerData['Prisoner']['id']) && (int)$prisonerData['Prisoner']['id'] != 0){
				$courtList 		= array();
				$prisoner_id 	= $prisonerData['Prisoner']['id'];
				/*
				 *Code for add the prisoner discharge records
				*/					
				if(isset($this->data['Discharge']) && is_array($this->data['Discharge']) && count($this->data['Discharge']) >0){
					if(isset($this->data['Discharge']['date_of_discharge']) && $this->data['Discharge']['date_of_discharge'] != ''){
						$this->request->data['Discharge']['date_of_discharge'] = date('Y-m-d', strtotime($this->data['Discharge']['date_of_discharge']));
					}
					if(isset($this->data['Discharge']['uuid']) && $this->data['Discharge']['uuid'] == ''){
						$uuidArr = $this->Discharge->query("select uuid() as code");
						$this->request->data['Discharge']['uuid'] 		= $uuidArr[0][0]['code'];
					}
					$this->request->data['Discharge']['prisoner_id'] 	= $prisoner_id;						
					if($this->Discharge->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/discharges/index/'.$uuid);
					}else{
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the prisoner discharge records
				*/				
		        if(isset($this->data['DischargeEdit']['id']) && (int)$this->data['DischargeEdit']['id'] != 0){
		            if($this->Discharge->exists($this->data['DischargeEdit']['id'])){
		                $this->data = $this->Discharge->findById($this->data['DischargeEdit']['id']);
		            }
		        }
		        /*
		         *Code for delete the prisoner discharge records
		         */	
		        if(isset($this->data['DischargeDelete']['id']) && (int)$this->data['DischargeDelete']['id'] != 0){
		            if($this->Discharge->exists($this->data['DischargeDelete']['id'])){
	                    $this->Discharge->id = $this->data['DischargeDelete']['id'];
	                    if($this->Discharge->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/discharges/index/'.$uuid);		                
		            }
		        }
		        /*
				 *Code for edit the Gate Pass records
				*/				
		        if(isset($this->data['GatePassEdit']['id']) && (int)$this->data['GatePassEdit']['id'] != 0){
		            if($this->GatePass->exists($this->data['GatePassEdit']['id'])){
		                $this->data = $this->GatePass->findById($this->data['GatePassEdit']['id']);
		            }
		        }
		        //add gate pass 
		        if(isset($this->data['GatePass']) && is_array($this->data['GatePass']) && count($this->data['GatePass']) >0){
					if(isset($this->data['GatePass']['gp_date']) && $this->data['GatePass']['gp_date'] != ''){
						$this->request->data['GatePass']['gp_date'] = date('Y-m-d', strtotime($this->request->data['GatePass']['gp_date']));
					}
					if(isset($this->data['GatePass']['uuid']) && $this->data['GatePass']['uuid'] == ''){
						$uuidArr = $this->GatePass->query("select uuid() as code");
						$this->request->data['GatePass']['uuid'] 		= $uuidArr[0][0]['code'];
					}
					$this->request->data['GatePass']['prisoner_id'] 	= $prisoner_id;	
					//echo '<pre>'; print_r($this->data); exit;
					if($this->GatePass->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/discharges/index/'.$uuid.'#gate_pass');
					}else{
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
		                //$this->redirect('/discharges/index/'.$prisoner_uuid.'#gate_pass');
					}
				}
		        /*
		         *Code for delete the Gate Pass records
		         */	
		         //Delete gate pass	
		         if(isset($this->data['GatePassDelete']['id']) && (int)$this->data['GatePassDelete']['id'] != 0){
		            if($this->GatePass->exists($this->data['GatePassDelete']['id'])){
	                    $this->GatePass->id = $this->data['GatePassDelete']['id'];
	                    if($this->GatePass->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/discharges/index/'.$uuid.'#gate_pass');		                
		            }
		        }	
		        /*
				 *Code for add the death in custody records
				*/					
				if(isset($this->data['DeathInCustody']) && is_array($this->data['DeathInCustody']) && count($this->data['DeathInCustody']) >0){
					if(isset($this->data['DeathInCustody']['date_of_death']) && $this->data['DeathInCustody']['date_of_death'] != ''){
						$this->request->data['DeathInCustody']['date_of_death'] = date('Y-m-d', strtotime($this->data['DeathInCustody']['date_of_death']));
					}
					if(isset($this->data['DeathInCustody']['uuid']) && $this->data['DeathInCustody']['uuid'] == ''){
						$uuidArr = $this->DeathInCustody->query("select uuid() as code");
						$this->request->data['DeathInCustody']['uuid'] 		= $uuidArr[0][0]['code'];
					}
					$this->request->data['DeathInCustody']['prisoner_id'] 	= $prisoner_id;						
					if($this->DeathInCustody->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/discharges/index/'.$uuid.'#death_in_custody');
					}else{
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}	
				/*
				 *Code for edit the death in custody records
				*/				
		        if(isset($this->data['DeathInCustodyEdit']['id']) && (int)$this->data['DeathInCustodyEdit']['id'] != 0){
		            if($this->DeathInCustody->exists($this->data['DeathInCustodyEdit']['id'])){
		                $this->data = $this->DeathInCustody->findById($this->data['DeathInCustodyEdit']['id']);
		            }
		        }  
		        /*
		         *Code for delete the death in custody records
		         */	
		        if(isset($this->data['DeathInCustodyDelete']['id']) && (int)$this->data['DeathInCustodyDelete']['id'] != 0){
		            if($this->DeathInCustody->exists($this->data['DeathInCustodyDelete']['id'])){
	                    $this->DeathInCustody->id = $this->data['DeathInCustodyDelete']['id'];
	                    if($this->DeathInCustody->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/discharges/index/'.$uuid.'#death_in_custody');
		            }
		        }	
		        /*
				 *Code for add the discharge on escape records
				*/					
				if(isset($this->data['DischargeEscape']) && is_array($this->data['DischargeEscape']) && count($this->data['DischargeEscape']) >0){
					if(isset($this->data['DischargeEscape']['date_of_escape']) && $this->data['DischargeEscape']['date_of_escape'] != ''){
						$this->request->data['DischargeEscape']['date_of_escape'] = date('Y-m-d', strtotime($this->data['DischargeEscape']['date_of_escape']));
					}
					if(isset($this->data['DischargeEscape']['date_of_recapture']) && $this->data['DischargeEscape']['date_of_recapture'] != ''){
						$this->request->data['DischargeEscape']['date_of_recapture'] = date('Y-m-d', strtotime($this->data['DischargeEscape']['date_of_recapture']));
					}
					if(isset($this->data['DischargeEscape']['uuid']) && $this->data['DischargeEscape']['uuid'] == ''){
						$uuidArr = $this->DischargeEscape->query("select uuid() as code");
						$this->request->data['DischargeEscape']['uuid'] 		= $uuidArr[0][0]['code'];
					}
					$this->request->data['DischargeEscape']['prisoner_id'] 	= $prisoner_id;						
					if($this->DischargeEscape->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/discharges/DischargeEscape/'.$uuid);
					}else{
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the discharge on escape records
				*/				
		        if(isset($this->data['DischargeEscapeEdit']['id']) && (int)$this->data['DischargeEscapeEdit']['id'] != 0){
		            if($this->DeathInCustody->exists($this->data['DischargeEscapeEdit']['id'])){
		                $this->data = $this->DischargeEscape->findById($this->data['DischargeEscapeEdit']['id']);
		            }
		        }
		        /*
		         *Code for delete the discharge on escape records
		         */	
		        if(isset($this->data['DischargeEscapeDelete']['id']) && (int)$this->data['DischargeEscapeDelete']['id'] != 0){
		            if($this->DischargeEscape->exists($this->data['DischargeEscapeDelete']['id'])){
	                    $this->DischargeEscape->id = $this->data['DischargeEscapeDelete']['id'];
	                    if($this->DischargeEscape->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/discharges/DischargeEscape/'.$uuid);		                
		            }
		        }	      
				/*
				 *Query for get the discharge type list
				 */
				$dischargetypeList = $this->DischargeType->find('list', array(
					'recursive'		=> -1,
					'fields'		=> array(
						'DischargeType.id',
						'DischargeType.name',
					),
					'conditions'	=> array(
						'DischargeType.is_enable'		=> 1,
						'DischargeType.is_trash'		=> 0,
					),
					'order'			=> array(
						'DischargeType.name',
					),
				));
				/*
				 *Query for get the Medical officers list
				 */
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
				  /*
				 *Query for get the sentence list
				 */
				  $sentences=$this->PrisonerSentenceDetail->find('list',array(
	                'fields'        => array(
	                    'PrisonerSentenceDetail.id',
	                    'PrisonerSentenceDetail.sentence',
	                ),
	                'conditions'=>array(
	                  'PrisonerSentenceDetail.prisoner_id'=>$prisonerData['Prisoner']['id'],//Gate keeper User
	                ),
	                'order'=>array(
	                  'PrisonerSentenceDetail.id'
	                )
         		 ));
				$this->set(array(
					'uuid'					=> $uuid,
					'dischargetypeList'		=> $dischargetypeList,
					'sentences'				=> $sentences,
					'medicalOfficers'		=> $medicalOfficers,
					'prisoner_id'			=> $prisoner_id
				));
			}else{
				return $this->redirect(array('controller'=>'prisoners', 'action' => 'index'));	
			}
		}else{
			return $this->redirect(array('controller'=>'prisoners', 'action' => 'index'));	
		}
    }
    public function indexAjax(){
		$this->layout 			= 'ajax';
    	$date_of_discharge 		= '';
    	$discharge_type_id 		= '';
    	$uuid 					= '';
    	$condition 				= array(
    		'Discharge.is_trash'		=> 0,
    	);
		if(isset($this->params['named']['date_of_discharge']) && $this->params['named']['date_of_discharge'] != ''){
    		$date_of_discharge = $this->params['named']['date_of_discharge'];
    		$condition += array(
    			'Discharge.date_of_discharge'	=> date('Y-m-d', strtotime($date_of_discharge)),
    		);    		
    	}
		if(isset($this->params['named']['discharge_type_id']) && $this->params['named']['discharge_type_id'] != ''){
    		$discharge_type_id = $this->params['named']['discharge_type_id'];
    		$condition += array(
    			'Discharge.discharge_type_id'	=> $discharge_type_id,
    		);     		
    	}      	
		if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
    		$uuid = $this->params['named']['uuid'];
    	}    	
		if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.doc');
            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }    	
    	$this->paginate = array(
    		'conditions'	=> $condition,
    		'order'			=> array(
    			'Discharge.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('Discharge');
    	$this->set(array(
    		'uuid'						=> $uuid,
    		'datas'						=> $datas,
    		'date_of_discharge'			=> $date_of_discharge,
    		'discharge_type_id'			=> $discharge_type_id,
    	));     	
    }
    //Get Prisoner GatePass list  
	public function gatepassAjax(){
		$this->layout 			= 'ajax';
    	$uuid 					= '';
    	$condition 				= array(
    		'GatePass.is_trash'		=> 0,
    	);	
		if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
    		$uuid = $this->params['named']['uuid'];
    		
    	}    	
		if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','gatepass_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','gatepass_report_'.date('d_m_Y').'.doc');
            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }    	
    	$this->paginate = array(
    		'conditions'	=> $condition,
    		'order'			=> array(
    			'GatePass.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('GatePass');
    	$this->set(array(
    		'uuid'						=> $uuid,
    		'datas'						=> $datas
    	));     	
    }
    //Death in custody
    public function DeathInCustodyAjax(){
		$this->layout 			= 'ajax';
    	$date_of_death 		= '';
    	
    	$uuid 					= '';
    	$condition 				= array(
    		'DeathInCustody.is_trash'		=> 0,
    	);
		if(isset($this->params['named']['date_of_death']) && $this->params['named']['date_of_death'] != ''){
    		$date_of_discharge = $this->params['named']['date_of_death'];
    		$condition += array(
    			'DeathInCustody.date_of_death'	=> date('Y-m-d', strtotime($date_of_death)),
    		);    		
    	}
		   	
		if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
    		$uuid = $this->params['named']['uuid'];
    	}    	
		if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.doc');
            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }    	
    	$this->paginate = array(
    		'conditions'	=> $condition,
    		'order'			=> array(
    			'DeathInCustody.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('DeathInCustody');
    	$this->set(array(
    		'uuid'						=> $uuid,
    		'datas'						=> $datas,
    		'date_of_death'			=> $date_of_death,
    		
    	));     	
    } 
    //Discharge on escape
    public function DischargeEscapeAjax(){
		$this->layout 			= 'ajax';
    	$date_of_escape 		= '';
    	
    	$uuid 					= '';
    	$condition 				= array(
    		'DischargeEscape.is_trash'		=> 0,
    	);
		if(isset($this->params['named']['date_of_escape']) && $this->params['named']['date_of_escape'] != ''){
    		$date_of_escape = $this->params['named']['date_of_escape'];
    		$condition += array(
    			'DischargeEscape.date_of_escape'	=> date('Y-m-d', strtotime($date_of_escape)),
    		);    		
    	}
		   	
		if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
    		$uuid = $this->params['named']['uuid'];
    	}    	
		if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','discharge_report_'.date('d_m_Y').'.doc');
            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }    	
    	$this->paginate = array(
    		'conditions'	=> $condition,
    		'order'			=> array(
    			'DischargeEscape.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('DischargeEscape');
    	$this->set(array(
    		'uuid'						=> $uuid,
    		'datas'						=> $datas,
    		'date_of_escape'			=> $date_of_escape,
    		
    	));     	
    }
}