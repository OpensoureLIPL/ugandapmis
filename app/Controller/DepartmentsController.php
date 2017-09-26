<?php
App::uses('AppController', 'Controller');

class DepartmentsController extends AppController{
    public $components = array('Paginator', 'Flash','Session');
    /**
     * Index Function
     */
    public function index(){
        $this->layout='table';
          $datas=$this->Department->find('all',array(
              'order'=>array(
                  'Department.name'
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
            if($this->Department->save($this->request->data)){
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
            if($this->Department->save($this->request->data)){
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
        $this->request->data=$this->Department->findById($id);
    }
    /**
     * Delete Function
     */
    public function delete($id){
        $this->Department->delete($id);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Deleted Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////
    public function disable($id){
        $this->Department->id=$id;
        $this->Department->saveField('is_enable',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////////
    public function enable($id){
        $this->Department->id=$id;
        $this->Department->saveField('is_enable',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
}
