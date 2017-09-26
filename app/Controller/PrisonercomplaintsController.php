<?php
App::uses('AppController', 'Controller');
class PrisonercomplaintsController  extends AppController {
	public $layout='table';
    public $uses = array('Prisoner');
	public function index() {
		$this->loadModel('Prisonercomplaint'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['PrisonercomplaintDelete']['id']) && (int)$this->data['PrisonercomplaintDelete']['id'] != 0){
        	
                 $this->Prisonercomplaint->id=$this->data['PrisonercomplaintDelete']['id'];
                 $this->Prisonercomplaint->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Prisonercomplaint'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Prisonercomplaint.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition +=array('date(Prisonercomplaint.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Prisonercomplaint.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Prisonercomplaint');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

    }
	public function add() { 
		$this->loadModel('Prisonercomplaint');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Prisonercomplaint']) && is_array($this->data['Prisonercomplaint']) && count($this->data['Prisonercomplaint'])>0){			
			if ($this->Prisonercomplaint->save($this->data)) {
				$this->Flash->success(__('The Prisoner complaints record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The Prisoner complaints record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['PrisonercomplaintEdit']['id']) && (int)$this->data['PrisonercomplaintEdit']['id'] != 0){
            if($this->Prisonercomplaint->exists($this->data['PrisonercomplaintEdit']['id'])){
                $this->data = $this->Prisonercomplaint->findById($this->data['PrisonercomplaintEdit']['id']);
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