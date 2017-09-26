<?php
App::uses('AppController', 'Controller');
class VisitorsController   extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('Visitor'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['VisitorDelete']['id']) && (int)$this->data['VisitorDelete']['id'] != 0){
        	
                 $this->Visitor->id=$this->data['VisitorDelete']['id'];
                 $this->Visitor->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Visitor'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Visitor.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition +=array('date(Visitor.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Visitor.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Visitor');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('Visitor');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Visitor']) && is_array($this->data['Visitor']) && count($this->data['Visitor'])>0){			
			if ($this->Visitor->save($this->data)) {
				$this->Flash->success(__('The Visitors record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The visitors record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['VisitorEdit']['id']) && (int)$this->data['VisitorEdit']['id'] != 0){
            if($this->Visitor->exists($this->data['VisitorEdit']['id'])){
                $this->data = $this->Visitor->findById($this->data['VisitorEdit']['id']);
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