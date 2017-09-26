<?php
App::uses('AppController', 'Controller');
class CourtattendancesController  extends AppController {
	public $layout='table';
    public $uses=array('Prisoner', 'Courtattendance', 'Court', 'Magisterial');
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
				 *Code for add the court attendance records
				*/					
				if(isset($this->data['Courtattendance']) && is_array($this->data['Courtattendance']) && count($this->data['Courtattendance']) >0){
					if(isset($this->data['Courtattendance']['attendance_date']) && $this->data['Courtattendance']['attendance_date'] != ''){
						$this->request->data['Courtattendance']['attendance_date'] = date('Y-m-d', strtotime($this->data['Courtattendance']['attendance_date']));
					}
					if(isset($this->data['Courtattendance']['uuid']) && $this->data['Courtattendance']['uuid'] == ''){
						$uuidArr = $this->Courtattendance->query("select uuid() as code");
						$this->request->data['Courtattendance']['uuid'] 		= $uuidArr[0][0]['code'];
					}
					$this->request->data['Courtattendance']['prisoner_id'] 	= $prisoner_id;						
					if($this->Courtattendance->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/courtattendances/index/'.$uuid);
					}else{
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				/*
				 *Code for edit the court attendance records
				*/				
		        if(isset($this->data['CourtattendanceEdit']['id']) && (int)$this->data['CourtattendanceEdit']['id'] != 0){
		            if($this->Courtattendance->exists($this->data['CourtattendanceEdit']['id'])){
		                $this->data = $this->Courtattendance->findById($this->data['CourtattendanceEdit']['id']);
		            }
		        }
		        /*
		         *Code for delete the court attendance records
		         */	
		        if(isset($this->data['CourtattendanceDelete']['id']) && (int)$this->data['CourtattendanceDelete']['id'] != 0){
		            if($this->Courtattendance->exists($this->data['CourtattendanceDelete']['id'])){
	                    $this->Courtattendance->id = $this->data['CourtattendanceDelete']['id'];
	                    if($this->Courtattendance->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/courtattendances/index/'.$uuid);		                
		            }
		        }		        
				/*
				 *Query for get the Magistrail area list
				 */
				$magestrilareaList = $this->Magisterial->find('list', array(
					'recursive'		=> -1,
					'fields'		=> array(
						'Magisterial.id',
						'Magisterial.name',
					),
					'conditions'	=> array(
						'Magisterial.is_enable'		=> 1,
						'Magisterial.is_trash'		=> 0,
					),
					'order'			=> array(
						'Magisterial.name',
					),
				));
				/*
				 *Query for get the court List
				 */
				if(isset($this->data['Courtattendance']['magisterial_id']) && (int)$this->data['Courtattendance']['magisterial_id'] != 0){
					$courtList = $this->Court->find('list', array(
						'recursive'		=> -1,
						'fields'		=> array(
							'Court.id',
							'Court.name',
						),
						'conditions'	=> array(
							'Court.is_enable'		=> 1,
							'Court.is_trash'		=> 0,
							'Court.magisterial_id'	=> $this->data['Courtattendance']['magisterial_id'],
						),
						'order'			=> array(
							'Court.name'
						),
					));
				}
				
				$this->set(array(
					'uuid'					=> $uuid,
					'courtList'				=> $courtList,
					'magestrilareaList'		=> $magestrilareaList,
					'prisoner_id' => $prisonerData['Prisoner']['id']
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
    	$production_warrent_no 	= '';
    	$attendance_date 		= '';
    	$attendance_time 		= '';
    	$magisterial_id 		= '';
    	$court_id 				= '';
    	$case_no				= '';
    	$uuid 					= '';
    	$condition 				= array(
    		'Courtattendance.is_trash'		=> 0,
    	);
    	if(isset($this->params['named']['production_warrent_no']) && $this->params['named']['production_warrent_no'] != ''){
    		$production_warrent_no = $this->params['named']['production_warrent_no'];
    		$condition += array(
    			0 => "Courtattendance.production_warrent_no LIKE '%$production_warrent_no%'"
    		);
    	}
		if(isset($this->params['named']['attendance_date']) && $this->params['named']['attendance_date'] != ''){
    		$attendance_date = $this->params['named']['attendance_date'];
    		$condition += array(
    			'Courtattendance.attendance_date'	=> date('Y-m-d', strtotime($attendance_date)),
    		);    		
    	}
		if(isset($this->params['named']['attendance_time']) && $this->params['named']['attendance_time'] != ''){
    		$attendance_time = $this->params['named']['attendance_time'];
    		$condition += array(
    			'Courtattendance.attendance_time'	=> $attendance_time,
    		);     		
    	}  
		if(isset($this->params['named']['magisterial_id']) && $this->params['named']['magisterial_id'] != ''){
    		$magisterial_id = $this->params['named']['magisterial_id'];
    		$condition += array(
    			'Courtattendance.magisterial_id'	=> $magisterial_id,
    		);      		
    	}  
		if(isset($this->params['named']['court_id']) && $this->params['named']['court_id'] != ''){
    		$court_id = $this->params['named']['court_id'];
    		$condition += array(
    			'Courtattendance.court_id'	=> $court_id,
    		);    		
    	}
		if(isset($this->params['named']['case_no']) && $this->params['named']['case_no'] != ''){
    		$case_no = $this->params['named']['case_no'];
    		$condition += array(
    			1 => "Courtattendance.case_no LIKE '%$case_no%'"
    		);    		
    	}
		if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
    		$uuid = $this->params['named']['uuid'];
    	}    	
		if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','court_attendance_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','court_attendance_report_'.date('d_m_Y').'.doc');
            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }    	
    	$this->paginate = array(
    		'conditions'	=> $condition,
    		'order'			=> array(
    			'Courtattendance.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('Courtattendance');
    	$this->set(array(
    		'uuid'						=> $uuid,
    		'datas'						=> $datas,
    		'case_no'					=> $case_no,
    		'court_id'					=> $court_id,
    		'magisterial_id'			=> $magisterial_id,
    		'attendance_time'			=> $attendance_time,
    		'attendance_date'			=> $attendance_date,
    		'production_warrent_no'		=> $production_warrent_no,
    	));     	      	    	    	    	
    }
    public function getCourtByMagisterial(){
    	$this->autoRender = false;
    	if(isset($this->data['magisterial_id']) && (int)$this->data['magisterial_id'] != 0){
    		$courtList = $this->Court->find('list', array(
    			'recursive'		=> -1,
    			'fields'		=> array(
    				'Court.id',
    				'Court.name',
    			),
    			'conditions'	=> array(
    				'Court.magisterial_id'	=> $this->data['magisterial_id']
    			),
    			'order'			=> array(
    				'Court.name',
    			),
    		));
    		if(is_array($courtList) && count($courtList)>0){
    			echo '<option value="">--Select Court--</option>';
    			foreach($courtList as $key=>$val){
    				echo '<option value="'.$key.'">'.$val.'</option>';
    			}
    		}else{
    			echo '<option value="">--Select Court--</option>';
    		}
    	}else{
    		echo '<option value="">--Select Court--</option>';
    	}
    }
}