<?php
App::uses('AppController', 'Controller');
class ShiftsController  extends AppController {
	public $layout='table';
	public function index() { 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['ShiftDelete']['id']) && (int)$this->data['ShiftDelete']['id'] != 0){
        	
                 $this->Shift->id=$this->data['ShiftDelete']['id'];
                 $this->Shift->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){ 
        $this->layout = 'ajax';
        $name  = '';
        $condition = array('Shift.is_trash' => 0);
        if(isset($this->params['named']['name']) && $this->params['named']['name'] != ''){
            $name = $this->params['named']['name'];
            $condition += array("Shift.name LIKE '%$name%'");
        } 
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Shift.name'
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('Shift');
        $this->set(array(
            'name'  => $name,
            'datas' => $datas,
        )); 
    }
	public function add() { 
		
		 //debug($staffcategory_id);
		if (isset($this->data['Shift']) && is_array($this->data['Shift']) && count($this->data['Shift'])>0){			
			if ($this->Shift->save($this->data)) {
				$this->Flash->success(__('The record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['ShiftEdit']['id']) && (int)$this->data['ShiftEdit']['id'] != 0){
            if($this->Shift->exists($this->data['ShiftEdit']['id'])){
                $this->data = $this->Shift->findById($this->data['ShiftEdit']['id']);
            }
        }
       
	}
}