<?php
App::uses('AppController', 'Controller');
class RecordstaffsController extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('RecordStaff'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['RecordStaffDelete']['id']) && (int)$this->data['RecordStaffDelete']['id'] != 0){
        	
        		 $this->RecordStaff->id=$this->data['RecordStaffDelete']['id'];
        		 $this->RecordStaff->saveField('is_trash',1);
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('RecordStaff'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('RecordStaff.is_trash'	=> 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition =array('date(RecordStaff.recorded_date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'RecordStaff.recorded_date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('RecordStaff');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('RecordStaff');
		$this->loadModel('Staffcategory');
		
          $staffcategory_id = $this->Staffcategory->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Staffcategory.id',
                        'Staffcategory.category_name',
                    ),
                    'conditions'    => array(
                        'Staffcategory.is_enable'     => 1,
                        'Staffcategory.is_trash'      => 0
                    ),
                    'order'         => array(
                        'Staffcategory.category_name'
                    ),
                ));
		 //debug($staffcategory_id);
		if (isset($this->data['RecordStaff']) && is_array($this->data['RecordStaff']) && count($this->data['RecordStaff'])>0){			
			if ($this->RecordStaff->save($this->data)) {
				$this->Flash->success(__('The staff record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The staff record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['RecordStaffEdit']['id']) && (int)$this->data['RecordStaffEdit']['id'] != 0){
            if($this->RecordStaff->exists($this->data['RecordStaffEdit']['id'])){
                $this->data = $this->RecordStaff->findById($this->data['RecordStaffEdit']['id']);
            }
        }
        $this->set(compact('staffcategory_id'));
	}
}