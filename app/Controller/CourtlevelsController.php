<?php
App::uses('AppController', 'Controller');
class CourtlevelsController  extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('Courtlevel'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['CourtlevelDelete']['id']) && (int)$this->data['CourtlevelDelete']['id'] != 0){
        	
                 $this->Courtlevel->id=$this->data['CourtlevelDelete']['id'];
                 $this->Courtlevel->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Courtlevel'); 
        $this->layout = 'ajax';
        $court_level_name  = '';
        $condition = array('Courtlevel.is_trash' => 0);
        if(isset($this->params['named']['court_level_name']) && $this->params['named']['court_level_name'] != ''){
            $court_level_name = $this->params['named']['court_level_name'];
            $condition += array("Courtlevel.court_level_name LIKE '%$court_level_name%'");
        } 
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Courtlevel.court_level_name'
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('Courtlevel');
        $this->set(array(
            'court_level_name'  => $court_level_name,
            'datas'             => $datas,
        )); 
    }
	public function add() { 
		$this->loadModel('Courtlevel');
		
		 //debug($staffcategory_id);
		if (isset($this->data['Courtlevel']) && is_array($this->data['Courtlevel']) && count($this->data['Courtlevel'])>0){			
			if ($this->Courtlevel->save($this->data)) {
				$this->Flash->success(__('The court level  record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The court level record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['CourtlevelEdit']['id']) && (int)$this->data['CourtlevelEdit']['id'] != 0){
            if($this->Courtlevel->exists($this->data['CourtlevelEdit']['id'])){
                $this->data = $this->Courtlevel->findById($this->data['CourtlevelEdit']['id']);
            }
        }
       
	}
}