<?php
App::uses('AppController', 'Controller');
class ShiftDeploymentsController  extends AppController {
	public $layout='table';
    public $uses = array('Shift','Officer','ShiftDeployment');
	public function index() { 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['ShiftDeploymentDelete']['id']) && (int)$this->data['ShiftDeploymentDelete']['id'] != 0){
        	
                 $this->ShiftDeployment->id=$this->data['ShiftDeploymentDelete']['id'];
                 $this->ShiftDeployment->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
        $shiftList = $this->Shift->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Shift.id',
                'Shift.name',
            ),
            'conditions'    => array(
                'Shift.is_enable'      => 1,
                'Shift.is_trash'       => 0
            ),
            'order'         => array(
                'Shift.name'
            ),
        ));
        $forceList = $this->Officer->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Officer.id',
                'Officer.force_number',
            ),
            'conditions'    => array(
                'Officer.is_enable'      => 1,
                'Officer.is_trash'       => 0,
                'Officer.force_number !='    => ''
            ),
            'order'         => array(
                'Officer.force_number'
            ),
        ));
        $this->set(array(
            'shiftList'  => $shiftList,
            'forceList'  => $forceList,
        )); 
    }
    public function indexAjax(){
     
        $this->layout = 'ajax';
        $shift_id = '';
        $force_id = '';
        $condition = array('ShiftDeployment.is_trash' => 0);

        if(isset($this->params['named']['shift_id']) && $this->params['named']['shift_id'] != ''){
            $shift_id = $this->params['named']['shift_id'];
            $condition += array("ShiftDeployment.shift_id"=>$shift_id);
        } 
        if(isset($this->params['named']['force_id']) && $this->params['named']['force_id'] != ''){
            $force_id = $this->params['named']['force_id'];
            $condition += array("ShiftDeployment.force_id"=>$force_id);
        } 
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'ShiftDeployment.name'
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('ShiftDeployment');
        $this->set(array(
            'datas' => $datas,
            'shift_id' => $shift_id,
            'force_id' => $force_id
        )); 
    }
	public function add() { 
		
		 //debug($staffcategory_id);
		if (isset($this->data['ShiftDeployment']) && is_array($this->data['ShiftDeployment']) && count($this->data['ShiftDeployment'])>0){	
        
            $this->request->data['ShiftDeployment']['shift_date'] = date('Y-m-d', strtotime($this->data['ShiftDeployment']['shift_date']));	
            //echo '<pre>'; print_r($this->data); exit;	
			if ($this->ShiftDeployment->save($this->data)) {
				$this->Flash->success(__('The record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['ShiftDeploymentEdit']['id']) && (int)$this->data['ShiftDeploymentEdit']['id'] != 0){
            if($this->ShiftDeployment->exists($this->data['ShiftDeploymentEdit']['id'])){
                $this->data = $this->ShiftDeployment->findById($this->data['ShiftDeploymentEdit']['id']);
            }
        }
       $shiftList = $this->Shift->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Shift.id',
                'Shift.name',
            ),
            'conditions'    => array(
                'Shift.is_enable'      => 1,
                'Shift.is_trash'       => 0
            ),
            'order'         => array(
                'Shift.name'
            ),
        ));
        $forceList = $this->Officer->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Officer.id',
                'Officer.force_number',
            ),
            'conditions'    => array(
                'Officer.is_enable'      => 1,
                'Officer.is_trash'       => 0,
                'Officer.force_number !='    => ''
            ),
            'order'         => array(
                'Officer.force_number'
            ),
        ));
        $this->set(array(
            'shiftList'  => $shiftList,
            'forceList'  => $forceList,
        ));
	}
}