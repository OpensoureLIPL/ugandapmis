<?php
App::uses('AppController', 'Controller');

class SitesController extends AppController{
    public $components = array('Paginator', 'Flash','Session');
    public $uses=array('Prisoner');
    // public function beforeFilter(){
    // parent::beforeFilter();
    //     $this->response->disableCache();
    //     if($this->Session->read('user_auth') == ''){
    //         $this->redirect(array(
    //             'controller'=>'sites',
    //             'action'=>'login'
    //         ));
    //     }
    // }
    public function login(){
        $this->loadModel('User');
        $this->layout='login';
        if($this->request->is(array('post','put'))){
            $data_exist=$this->User->find('count',array(
              'conditions'=>array(
                'User.login_id'=>$this->request->data['User']['login_id'],
                'User.password'=>$this->request->data['User']['password'],
                'User.is_enable'=>1
              )
            ));

            if($data_exist > 0){
              $user_auth=$this->User->find('first',array(
                'conditions'=>array(
                  'User.login_id'=>$this->request->data['User']['login_id'],
                  'User.password'=>$this->request->data['User']['password'],
                  'User.is_enable'=>1
                )
              ));
              $this->Session->write('user_auth',$user_auth);

              
                 $this->redirect(array(
                      'controller'=>'sites',
                      'action'=>'dashboard'
                  ));
              
             
            }else{
              $this->Session->write('message_type','error');
              $this->Session->write('message','Invalid Credential! Please provide correct login id and password.');
            }

        }
    }
    //////////////////////////////////////
    public function dashboard(){
      $this->layout='table';
     
    }
}
