<?php
App::uses('AppController', 'Controller');
class LetterinoutsController  extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('Letterinout'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['LetterinoutDelete']['id']) && (int)$this->data['LetterinoutDelete']['id'] != 0){
        	
                 $this->Letterinout->id=$this->data['LetterinoutDelete']['id'];
                 $this->Letterinout->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Letterinout'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Letterinout.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition =array('date(Letterinout.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Letterinout.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Letterinout');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('Letterinout');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Letterinout']) && is_array($this->data['Letterinout']) && count($this->data['Letterinout'])>0){			
			if ($this->Letterinout->save($this->data)) {
				$this->Flash->success(__('The prisoners in out  record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The prisoners in out record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['LetterinoutEdit']['id']) && (int)$this->data['LetterinoutEdit']['id'] != 0){
            if($this->Letterinout->exists($this->data['LetterinoutEdit']['id'])){
                $this->data = $this->Letterinout->findById($this->data['LetterinoutEdit']['id']);
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