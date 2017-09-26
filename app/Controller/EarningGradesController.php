<?php
App::uses('AppController', 'Controller');
class EarningGradesController   extends AppController {
    public $layout='table';
    public $uses=array('EarningGrade');
    public function index(){
        		/*
				 *Code for add the court attendance records
				*/				
				if(isset($this->data['EarningGrade']) && is_array($this->data['EarningGrade']) && count($this->data['EarningGrade']) >0){
					
					if(isset($this->data['EarningGrade']['uuid']) && $this->data['EarningGrade']['uuid'] == ''){
						$uuidArr = $this->EarningGrade->query("select uuid() as code");
						$this->request->data['EarningGrade']['uuid'] = $uuidArr[0][0]['code'];
						
					}
					if($this->EarningGrade->save($this->data)){
	                    $this->Session->write('message_type','success');
	                    $this->Session->write('message','Saved Successfully !');
	                    $this->redirect('/earningGrades');
					}else{
					
		                $this->Session->write('message_type','error');
		                $this->Session->write('message','Saving Failed !');
					}
				}
				
				/*
				 *Code for edit the court attendance records
				*/				
		        if(isset($this->data['EarningGradeEdit']['id']) && (int)$this->data['EarningGradeEdit']['id'] != 0){
		            if($this->EarningGrade->exists($this->data['EarningGradeEdit']['id'])){
		                $this->data = $this->EarningGrade->findById($this->data['EarningGradeEdit']['id']);
		            }
		        }
		        /*
		         *Code for delete the court attendance records
		         */	
		        if(isset($this->data['EarningGradeDelete']['id']) && (int)$this->data['EarningGradeDelete']['id'] != 0){
		            if($this->EarningGrade->exists($this->data['EarningGradeDelete']['id'])){
	                    $this->EarningGrade->id = $this->data['EarningGradeDelete']['id'];
	                    if($this->EarningGrade->saveField('is_trash',1)){
							$this->Session->write('message_type','success');
		                    $this->Session->write('message','Deleted Successfully !');
	                    }else{
							$this->Session->write('message_type','error');
		                    $this->Session->write('message','Delete Failed !');
	                    }
	                    $this->redirect('/earningGrades/');		                
		            }
		        }		        
				
            
                
    }
    public function indexAjax()
	 {
	 	$this->layout 			= 'ajax';
    	$name 		= '';
    	$grade_description 		= '';
    	
    	$condition 				= array(
    		'EarningGrade.is_trash'		=> 0,
    	);
		if(isset($this->params['named']['name']) && $this->params['named']['name'] != ''){
    		$name = $this->params['named']['name'];
    		$condition += array(
    			'EarningGrade.name'	=> $name,
    		);    		
    	}
		if(isset($this->params['named']['grade_description']) && $this->params['named']['grade_description'] != ''){
    		$grade_description = $this->params['named']['grade_description'];
    		$condition += array(
    			'EarningGrade.grade_description'	=> $grade_description,
    		);     		
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
    		 'EarningGrade.modified'	=> 'DESC',
    		),
    	)+$limit;
    	$datas = $this->paginate('EarningGrade');
    	$this->set(array(
    		'datas'						=> $datas,
    		'name'						=> $name,
    		'grade_description'			=> $grade_description,
    	));     	
    	}

	 

 }