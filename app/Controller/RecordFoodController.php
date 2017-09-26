<?php
App::uses('AppController', 'Controller');
class RecordFoodController  extends AppController {
	public $layout='table';
    public $uses = array('Prison');
	public function index() {
		$this->loadModel('RecordFood'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['RecordFoodDelete']['id']) && (int)$this->data['RecordFoodDelete']['id'] != 0){
        	
                 $this->RecordFood->id=$this->data['RecordFoodDelete']['id'];
                 $this->RecordFood->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('RecordFood'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('RecordFood.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition +=array('date(RecordFood.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'RecordFood.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('RecordFood');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('RecordFood');
		
		 //debug($staffcategory_id);
		if (isset($this->data['RecordFood']) && is_array($this->data['RecordFood']) && count($this->data['RecordFood'])>0){			
			if ($this->RecordFood->save($this->data)) {
				$this->Flash->success(__('The Food record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The Food record  could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['RecordFoodEdit']['id']) && (int)$this->data['RecordFoodEdit']['id'] != 0){
            if($this->RecordFood->exists($this->data['RecordFoodEdit']['id'])){
                $this->data = $this->RecordFood->findById($this->data['RecordFoodEdit']['id']);
            }
        }
       //get prison list
          $prisonList = $this->Prison->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Prison.id',
                'Prison.name',
            ),
            'conditions'    => array(
                'Prison.is_enable'      => 1,
                'Prison.is_trash'       => 0
            ),
            'order'         => array(
                'Prison.name'
            ),
        ));
        $this->set(array(
            'prisonList'    => $prisonList
        ));
	}
}