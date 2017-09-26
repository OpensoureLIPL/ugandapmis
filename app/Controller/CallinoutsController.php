<?php
App::uses('AppController', 'Controller');
class CallinoutsController   extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('Callinout'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['CallinoutDelete']['id']) && (int)$this->data['CallinoutDelete']['id'] != 0){
        	
                 $this->Callinout->id=$this->data['CallinoutDelete']['id'];
                 $this->Callinout->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Callinout'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Callinout.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition =array('date(Callinout.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Callinout.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Callinout');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('Callinout');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Callinout']) && is_array($this->data['Callinout']) && count($this->data['Callinout'])>0){			
			if ($this->Callinout->save($this->data)) {
				$this->Flash->success(__('The calls received or outgoing record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The calls received or outgoing record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['CallinoutEdit']['id']) && (int)$this->data['CallinoutEdit']['id'] != 0){
            if($this->Callinout->exists($this->data['CallinoutEdit']['id'])){
                $this->data = $this->Callinout->findById($this->data['CallinoutEdit']['id']);
            }
        }
       //get prisoner list
          $prisonerList = $this->Prisoner->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Prisoner.id',
                'Prisoner.prisoner_no',
            ),
            'conditions'    => array(
                'Prisoner.is_enable'      => 1,
                'Prisoner.is_trash'       => 0
            ),
            'order'         => array(
                'Prisoner.prisoner_no'
            ),
        ));
        $this->set(array(
            'prisonerList'    => $prisonerList
        ));
	}
}