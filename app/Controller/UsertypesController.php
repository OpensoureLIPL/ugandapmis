<?php
App::uses('AppController','Controller');
class UsertypesController extends AppController{
    public $layout='table';
    public function index(){
        $this->loadModel('Usertype');
        if(isset($this->data['UsertypeDelete']['id']) && (int)$this->data['UsertypeDelete']['id'] != 0){
            if($this->Usertype->exists($this->data['UsertypeDelete']['id'])){
                if($this->Usertype->updateAll(array('Usertype.is_trash' => 1), array('Usertype.id'  => $this->data['UsertypeDelete']['id']))){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Deleted Successfully !');
                }else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Deleted Failed !');
                }
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Deleted Failed !');                
            }
        }   
        $datas=$this->Usertype->find('all',array(
            'conditions'    => array(
                'Usertype.is_trash' => 0,
                'Usertype.id !='    => Configure::read('SUPERADMIN_USERTYPE'),
            ),
            'order'         => array(
                'Usertype.name'
            ),
            'limit'         => 50,
        ));             
        $this->set(compact('datas'));
    }
    public function add(){
        if($this->request->is(array('post','put')) && isset($this->data['Usertype']) && is_array($this->data['Usertype']) && count($this->data['Usertype']) >0){
            if($this->Usertype->save($this->request->data)){
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved Successfully !');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Saving Failed !');
            }
        }
        if(isset($this->data['UsertypeEdit']['id']) && (int)$this->data['UsertypeEdit']['id'] != 0){
            if($this->Usertype->exists($this->data['UsertypeEdit']['id'])){
                $this->data = $this->Usertype->findById($this->data['UsertypeEdit']['id']);
            }
        }
        $rparents=$this->Usertype->find('list',array(
            'conditions'=>array(
                'Usertype.is_enable'=>1,
            ),
            'order'=>array(
                'Usertype.name'
            ),
        ));
        $this->set('is_enables',$this->is_enables);        
        $this->set(compact('rparents'));
    }
}