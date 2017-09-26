<?php
App::uses('AppController', 'Controller');
class PrisonerinoutsController  extends AppController {
	public $layout='table';
   public $uses=array('Prisonerinout','Prisoner','User','Usertype');
	public function index() {
		
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['PrisonerinoutDelete']['id']) && (int)$this->data['PrisonerinoutDelete']['id'] != 0){
        	
                 $this->Prisonerinout->id=$this->data['PrisonerinoutDelete']['id'];
                 $this->Prisonerinout->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	
        $this->layout = 'ajax';
        $from  = '';
        $to  = '';
        $condition = array('Prisonerinout.is_trash'   => 0);
       
        if(isset($this->params['named']['from']) && $this->params['named']['to'] ){
             $from = $this->params['named']['from'];
             $to = $this->params['named']['to'];
              $condition =array('date(Prisonerinout.date) BETWEEN ? and ?' => array($from , $to));
            //$condition += array("RecordStaff.recorded_date BETWEEN $from and $to ");
        } 

        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Prisonerinout.date'
            ),            
            'limit'         => 20,
        );

        $datas  = $this->paginate('Prisonerinout');

        $this->set(array(
            'from'         => $from,
            'to'         => $to,
            'datas'             => $datas,
        )); 
        

    }
	public function add() { 
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
		
		 //debug($staffcategory_id);
		if (isset($this->data['Prisonerinout']) && is_array($this->data['Prisonerinout']) && count($this->data['Prisonerinout'])>0){			
			if ($this->Prisonerinout->save($this->data)) {
				$this->Flash->success(__('The prisoners in out  record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The prisoners in out record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['PrisonerinoutEdit']['id']) && (int)$this->data['PrisonerinoutEdit']['id'] != 0){
            if($this->Prisonerinout->exists($this->data['PrisonerinoutEdit']['id'])){
                $this->data = $this->Prisonerinout->findById($this->data['PrisonerinoutEdit']['id']);
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
            'prisonerList'    => $prisonerList,
             'gateKeepers'    => $gateKeepers,
        ));
	}
}