<?php
App::uses('Controller', 'Controller');

class DesignationsController extends AppController{
    public $components = array('Paginator', 'Flash','Session');
    /**
     * Index Function
     */
    public function index(){
        $this->layout='table';
          $datas=$this->Designation->find('all',array(
              'order'=>array(
                  'Designation.name'
              )
          ));
          $this->set(compact('datas'));
    }
    /**
     * Add Function
     */
    public function add(){
        $this->layout='table';
        if($this->request->is(array('post','put'))){
            if($this->Designation->save($this->request->data)){
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved Successfully !');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Saving Failed !');
            }
        }
        $is_enable=array(
            '0'=>'In Active',
            '1'=>'Active'
        );
        $this->set(compact('is_enable'));
    }
    /**
     * Edit Function
     */
    public function edit($id){
        $this->layout='table';
        if($this->request->is(array('post','put'))){
            if($this->Designation->save($this->request->data)){
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved Successfully !');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Saving Failed !');
            }
        }
        $is_enable=array(
            '0'=>'In Active',
            '1'=>'Active'
        );
        $this->set(compact('is_enable'));
        $this->request->data=$this->Designation->findById($id);
    }
    /**
     * Delete Function
     */
    public function delete($id){
        $this->Designation->delete($id);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Deleted Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////
    public function disable($id){
        $this->Designation->id=$id;
        $this->Designation->saveField('is_enable',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////////
    public function enable($id){
        $this->Designation->id=$id;
        $this->Designation->saveField('is_enable',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
}
