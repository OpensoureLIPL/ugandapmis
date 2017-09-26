<?php
App::uses('AppController', 'Controller');
class PersoninoutsController  extends AppController {
	public $layout='table';
   public $uses=array('Personinout','User','Usertype');
	public function index() {
		$this->loadModel('Personinout'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['PersoninoutDelete']['id']) && (int)$this->data['PersoninoutDelete']['id'] != 0){
        	
                 $this->Personinout->id=$this->data['PersoninoutDelete']['id'];
                 $this->Personinout->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Personinout'); 
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Personinout.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition =array('date(Personinout.person_in_out_date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Personinout.person_in_out_date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Personinout');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 

      

    }
	public function add() { 
		$this->loadModel('Personinout');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Personinout']) && is_array($this->data['Personinout']) && count($this->data['Personinout'])>0){			
			if ($this->Personinout->save($this->data)) {
				$this->Flash->success(__('The person in out  record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The person in out record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['PersoninoutEdit']['id']) && (int)$this->data['PersoninoutEdit']['id'] != 0){
            if($this->Personinout->exists($this->data['PersoninoutEdit']['id'])){
                $this->data = $this->Personinout->findById($this->data['PersoninoutEdit']['id']);
            }
        }
         $gateKeepers=$this->User->find('list',array(
                'fields'        => array(
                    'User.id',
                    'User.first_name',
                ),
                'conditions'=>array(
                  'User.is_enable'=>1,
                  'User.is_trash'=>0,
                  'User.usertype_id'=>10,//Gate keeper User
                ),
                'order'=>array(
                  'User.first_name'
                )
          ));

          $this->set(compact('gateKeepers'));
       
       
	}
}