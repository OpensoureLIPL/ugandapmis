<?php
App::uses('AppController', 'Controller');
class CourtsController  extends AppController {
	public $layout='table';
	public function index() {
		$this->loadModel('Court'); 
		//debug($this->data['RecordStaffDelete']['id']);
		//return false;
        if(isset($this->data['CourtDelete']['id']) && (int)$this->data['CourtDelete']['id'] != 0){
        	
                 $this->Court->id=$this->data['CourtDelete']['id'];
                 $this->Court->saveField('is_trash',1);
        		 
			     $this->Session->write('message_type','success');
			     $this->Session->write('message','Deleted Successfully !');
			     $this->redirect(array('action'=>'index'));
        	
        }
    }
    public function indexAjax(){
      	$this->loadModel('Court'); 
        $this->layout = 'ajax';
        $court_name  = '';
        $condition = array('Court.is_trash' => 0);
        if(isset($this->params['named']['court_name']) && $this->params['named']['court_name'] != ''){
            $court_name = $this->params['named']['court_name'];
            $condition += array("Court.court_name LIKE '%$court_name%'");
        } 
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Court.court_name'
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('Court');
        $this->set(array(
            'court_name'  => $court_name,
            'datas'             => $datas,
        )); 
       // debug($datas );
    }
	public function add() { 
		$this->loadModel('Court');
        $this->loadModel('Courtlevel');
		$court_level_id=$this->Courtlevel->find('list',array(
                'conditions'=>array(
                  'Courtlevel.is_enable'=>1,
                  'Courtlevel.is_trash'=>0,
                ),
                'order'=>array(
                  'Courtlevel.name'
                )
          ));
          $this->loadModel('Magisterial');
          $magisterial_id=$this->Magisterial->find('list',array(
                'conditions'=>array(
                  'Magisterial.is_enable'=>1,
                  'Magisterial.is_trash'=>0,
                ),
                'order'=>array(
                  'Magisterial.name'
                )
          ));
          $this->loadModel('State');
          $state=$this->State->find('list',array(
                'conditions'=>array(
                  'State.is_enable'=>1,
                  'State.is_trash'=>0,
                ),
                'order'=>array(
                  'State.name'
                )
          ));
          $this->loadModel('District');
          $district=$this->District->find('list',array(
                'conditions'=>array(
                  'District.is_enable'=>1,
                  'District.is_trash'=>0,
                ),
                'order'=>array(
                  'District.name'
                )
          ));
		 //debug($staffcategory_id);
		if (isset($this->data['Court']) && is_array($this->data['Court']) && count($this->data['Court'])>0){			
			if ($this->Court->save($this->data)) {
				$this->Flash->success(__('The court record has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The court level record could not be saved. Please, try again.'));
			}
		}
        if(isset($this->data['CourtEdit']['id']) && (int)$this->data['CourtEdit']['id'] != 0){
            if($this->Court->exists($this->data['CourtEdit']['id'])){
                $this->data = $this->Court->findById($this->data['CourtEdit']['id']);
            }
        }
        $this->set(compact('court_level_id','magisterial_id','state','district'));
        //debug($court_level_id);
	}
}