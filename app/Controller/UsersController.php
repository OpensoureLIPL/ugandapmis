<?php
App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController{
    public $layout='table';
    public $uses=array('User', 'Department', 'Designation', 'Usertype', 'State', 'District', 'Prison','Officer');
    public function index() {
        if(isset($this->data['UserDelete']['id']) && (int)$this->data['UserDelete']['id'] != 0){
            if($this->User->exists($this->data['UserEdit']['id'])){
                if($this->User->updateAll(array('User.is_trash' => 1), array('User.id' => $this->data['UserEdit']['id']))){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Delete Successfully !');
                }else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Delete Failed !');
                }
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Delete Failed !');                
            }
        }
    }
    public function indexAjax(){
        $this->layout   = 'ajax';
        $from_date      = '';
        $to_date        = '';
        $condition      = array(
            'User.is_trash'         => 0,
            'User.usertype_id !='   => Configure::read('SUPERADMIN_USERTYPE'),
        );
        if(isset($this->params['named']['from_date']) && $this->params['named']['from_date'] != ''){
            $from_date = $this->params['named']['from_date'];
            $condition += array('DATE(User.created) >=' => $from_date );
        }
        if(isset($this->params['named']['to_date']) && $this->params['named']['to_date'] != ''){
            $to_date = $this->params['named']['to_date'];
            $condition += array('DATE(User.created) <=' => $to_date );
        }    
        if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
            if($this->params['named']['reqType']=='XLS'){
                $this->layout='export_xls';
                $this->set('file_type','xls');
                $this->set('file_name','mis_report_'.date('d_m_Y').'.xls');
            }else if($this->params['named']['reqType']=='DOC'){
                $this->layout='export_xls';
                $this->set('file_type','doc');
                $this->set('file_name','mis_report_'.date('d_m_Y').'.doc');
            }else if($this->params['named']['reqType']=='PDF'){

            }
            $this->set('is_excel','Y');         
            $limit = array('limit' => 2000,'maxLimit'   => 2000);
        }else{
            $limit = array('limit'  => 20);
        }                       
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         => array(
                'User.modified',
            ),
        )+$limit;
        $datas = $this->paginate('User');
        $this->set(array(
            'datas'         => $datas,
            'from_date'     => $from_date,
            'to_date'       => $to_date,            
        ));
    }
//////////////////////////////////
    public function add(){
        $superadmin_usertype    = Configure::read('SUPERADMIN_USERTYPE');
        $superadmin_desig       = Configure::read('SUPERADMIN_DESIGNATION');   
        $districtList           = array();       
        if($this->request->is(array('post','put')) && isset($this->data['User']) && is_array($this->data['User']) && count($this->data['User']) >0){
            $uuid = $this->User->query("select uuid() as code");
            $uuid = $uuid[0][0]['code'];
            $this->request->data['User']['uuid'] = $uuid;
            $this->request->data['User']['name'] = trim($this->data['User']['first_name']).' '.trim($this->data['User']['last_name']);
            if($this->User->save($this->request->data)){

                $this->request->data["Officer"]['first_name']=$this->request->data['User']['first_name'];
                $this->request->data["Officer"]['last_name']=$this->request->data['User']['last_name'];
                $this->request->data["Officer"]['prison_id']=$this->request->data['User']['prison_id'];
                $this->request->data["Officer"]['force_number']=$this->request->data['User']['force_number'];
               
                $officerList = $this->Officer->find('first', array(
                    'conditions'    => array(
                        'Officer.force_number'    => $this->request->data['User']['force_number'],
                    ),
                ));
                if(count($officerList)>0)
                {
                    $first_name=$this->request->data['User']['first_name'];
                    $last_name=$this->request->data['User']['last_name'];
                    $prison_id=$this->request->data['User']['prison_id'];
                    $force_number=$this->request->data['User']['force_number'];
                    $this->Officer->updateAll(
                    array('Officer.first_name' => "'$first_name'",'Officer.last_name' => "'$last_name'",'Officer.prison_id' => "'$prison_id'"),
                    array('Officer.force_number' => $this->request->data['User']['force_number'])
                  );
                }
                else{
                    $this->Officer->saveAll($this->request->data["Officer"]);
                }
                
            
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved Successfully !');
                $this->redirect(array('action'=>'index'));
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Saving Failed !');
            }
        }
        if(isset($this->data['UserEdit']['id']) && (int)$this->data['UserEdit']['id'] != 0){
            if($this->User->exists($this->data['UserEdit']['id'])){
                $this->data = $this->User->findById($this->data['UserEdit']['id']);
                $this->request->data['User']['password'] = '';
            }
        }
        $designationList = $this->Designation->find('list',array(
            'recursive'     => -1,
            'fields'        => array(
                'Designation.id',
                'Designation.name',
            ),
            'conditions'    => array(
                'Designation.is_enable' => 1,
                'Designation.is_trash'  => 0,
                "Designation.id NOT IN ($superadmin_desig)"
            ),
            'order'=>array(
                'Designation.name'
            )
        ));
        $departmentList = $this->Department->find('list',array(
            'recursive'     => -1,
            'fields'        => array(
                'Department.id',
                'Department.name',
            ),
            'conditions'    => array(
                'Department.is_enable'  => 1,
                'Department.is_trash'   => 0
            ),
            'order'         => array(
                'Department.name'
            )
        ));
        $usertypeList = $this->Usertype->find('list', array(
            'recursive'     => -1,
            'conditions'    => array(
                'Usertype.is_enable'    => 1,
                'Usertype.is_trash'     => 0,
                "Usertype.id NOT IN ($superadmin_usertype)"
            ),
            'fields'        => array(
                'Usertype.id',
                'Usertype.name',
            ),
            'order'         => array(
                'Usertype.name' => 'ASC',
            ),
        ));
        $stateList = $this->State->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'State.id',
                'State.name'
            ),
            'conditions'    => array(
                'State.is_trash'    => 0,
                'State.is_enable'   => 1,
            ),
            'order'         => array(
                'State.name'
            ),
        ));
        $prisonList = $this->Prison->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Prison.id',
                'Prison.name',
            ),
            'conditions'    => array(
                'Prison.is_trash'   => 0,
                'Prison.is_enable'  => 1,
            ),
            'order'         => array(
                'Prison.name'
            ),
        ));
        if(isset($this->data['User']['state_id']) && (int)$this->data['User']['state_id'] != 0){
            $districtList = $this->District->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'District.id',
                    'District.name',
                ),
                'conditions'    => array(
                    'District.state_id'     => $this->data['User']['state_id'],
                    'District.is_enable'    => 1,
                    'District.is_trash'     => 0
                ),
            ));
        }
        $view_data = compact('designationList','departmentList', 'usertypeList', 'stateList', 'prisonList', 'districtList');
        $this->set($view_data);
    }
//////////////////////////////
    public function enable($id){
        $this->User->id=$id;
        $this->User->saveField('is_enable',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
//////////////////////////////
    public function disable($id){
        $this->User->id=$id;
        $this->User->saveField('is_enable',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
////////////////////////////////
    public function disableadmin($id){
        $this->User->id=$id;
        $this->User->saveField('is_admin',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled as Admin Successfully !');
        $this->redirect(array('action'=>'index'));
    }
////////////////////////////////
    public function enableadmin($id){
        $this->User->id=$id;
        $this->User->saveField('is_admin',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled as Admin Successfully !');
        $this->redirect(array('action'=>'index'));
    }
/*
 *Login Function
 */
    public function login(){ 
        $this->layout = 'login';
        $this->Session->delete('message_type');
        $this->Session->delete('message');        
        if($this->request->is('post')){
            if($this->data['User']['username'] == '' && $this->data['User']['password'] == ''){ 
                $this->Session->write('message_type','error');
                $this->Session->write('message','Please Enter User Name, Password !');                     
            }else if($this->data['User']['username'] == '' && $this->data['User']['password'] != ''){     
                $this->Session->write('message_type','error');
                $this->Session->write('message','Please Enter User Name !');                         
            }else{
                $user = $this->User->findByUsername($this->data['User']['username']);
                if(is_array($user) && count($user) > 0 && isset($user['User']['password']) && trim($user['User']['password']) != ''){ 
                    $postedPassword     = $this->data['User']['appSalt'];
                    $originalPassword   = $user['User']['password'];
                    $saltingOriginalPwd = md5($user['User']['password'].$this->Session->read('appSalt'));
                    
                    if($saltingOriginalPwd == $postedPassword){
                        if($this->Auth->login($user['User'])) {
                            $this->Session->write('message_type','success');
                            $this->Session->write('message','Successfully Logged In !');                             
                            return $this->redirect($this->Auth->redirect());
                        }else{
                            //$this->Session->setFlash('Username or password is incorrect','default', array('class' => 'message'));
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Username or password is incorrect !');                            
                            $this->request->data['User']['username']    = '';
                            $this->request->data['User']['password']    = '';
                        }
                    }else{
                        //$this->Session->setFlash('Username or password is incorrect','default', array('class' => 'message')); 
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Username or password is incorrect !');                            
                    }
                }else{
                    //$this->Session->setFlash('Invalid Login.Username or password is incorrect','default', array('class' => 'message'));   
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Invalid Login.Username or password is incorrect !');
                }
            }  
        }        
        /*
         * Generate Salt
         */
        $appSalt = $this->generateMySalt();
        $this->Session->write('appSalt',$appSalt);
        $this->set(array(
            'appSalt'       => $appSalt,
        ));
    }
/*
 *Logout Function
 */    
    public function logout() {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
/*
 *Function for get the backup of whole database
 */    
    public function backupDatabase(){
        if(isset($this->data['DatabaseBackup']) && is_array($this->data['DatabaseBackup']) && count($this->data['DatabaseBackup'])>0){
            $this->loadModel('DatabaseBackup');
            $softName       = 'database_backup_'.date('d-m-Y-H:i:s-a').'.sql';
            $pathName       = './files/Backup/'.$softName;            
            $backup_cmd = "mysqldump --user=root --password=password --host=localhost uganda > $pathName";
            exec($backup_cmd);
            $this->request->data['DatabaseBackup']['name']       = $softName;
            $this->request->data['DatabaseBackup']['created_by'] = $softName;
            if($this->DatabaseBackup->save($this->data)){
                $this->Session->write('message_type','success');
                $this->Session->write('message','Database application backup successfully completed !'); 
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Invalid request, please try again !');  
            }
            $this->redirect(array('controller'=>'Users','action'=>'backupDatabase'));           
        }
    }
    public function backupDatabaseAjax(){
        $this->layout   = 'ajax';
        $this->loadModel('DatabaseBackup');
        $condition      = array();
        $from_date      = '';
        $to_date        = '';
        if(isset($this->params['named']['from_date']) && $this->params['named']['from_date'] != ''){
            $from_date = $this->params['named']['from_date'];
            $condition += array('DATE(DatabaseBackup.created) >=' => date('Y-m-d', strtotime($from_date)) );
        }
        if(isset($this->params['named']['to_date']) && $this->params['named']['to_date'] != ''){
            $to_date = $this->params['named']['to_date'];
            $condition += array('DATE(DatabaseBackup.created) <=' => date('Y-m-d', strtotime($to_date)) );
        }                
        $this->paginate = array(
            'recurive'      => -1,
            'conditions'    => $condition,
            'order'         => array(
                'DatabaseBackup.created'    => 'DESC',
            ),
            'limit'         => 1,
        );
        $datas = $this->paginate('DatabaseBackup'); 
        $this->set(array(
            'datas'     => $datas,
            'from_date' => $from_date,
            'to_date'   => $to_date,
        ));
    }
    public function changePassword(){
        if(isset($this->data['User']) && is_array($this->data['User']) && count($this->data['User'])>0){
            $this->request->data['User']['id'] = $this->Auth->user('id');
            if(isset($this->request->data['User']['id']) && (int)$this->request->data['User']['id'] != 0){
                $this->request->data['User']['password'] = $this->request->data['User']['new_password'];
                if(isset($this->request->data['User']['password']) && $this->request->data['User']['password'] != ''){
                    if($this->User->save($this->data)){
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Password Changed Successfully !');
                        $this->redirect(array('action'=>'changePassword'));
                    }else{
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Invalid request, please try again !');                       
                    }
                }else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Invalid request, please try again !');                     
                }
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Invalid request, please try again !');   
            }
        }
        $this->set(array(
            'title'     => 'Change Password',
        ));
    }
    public function checkCurrentPassword(){
        $this->autoRender = false;
        $this->loadModel('User');
        if(isset($this->data['cur_pass']) && $this->data['cur_pass'] != ''){
            if($this->Auth->user('id')){
                $count = $this->User->find('count', array(
                    'recursive'     => -1,
                    'conditions'    => array(
                        'User.id'       => $this->Auth->user('id'),
                        'User.password' => md5($this->data['cur_pass']),
                    ),
                ));
                if($count){
                    echo 'SUCC';
                }else{
                    echo 'FAIL';
                }
            }else{
                echo 'FAIL';    
            }
        }else{
            echo 'FAIL';
        }
    }
    public function PasswordComplexicity(){
        $this->autoRender = false;
        if(isset($this->data['new_pass']) && $this->data['new_pass'] != ''){
            $newPassword = $this->request->data['new_pass'];
            if(strlen($newPassword)<=8){
                echo "MIN";
            }else{
                if(preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $newPassword)) {
                    echo "SUCC";
                }else{
                    echo "FAIL";
                }
            }
        }else{
            echo "FAIL";
        }  
    }
    public function resetPassword(){
        $this->autoRender = false;
        $this->loadModel('User');
        if(isset($this->data['UserResetPassword']['id']) && (int)$this->data['UserResetPassword']['id'] != 0){
            $data['User']['id']         = $this->data['UserResetPassword']['id'];
            $data['User']['password']   = md5('Password123');
            if($this->User->save($data,$validate = false)){
                $this->Session->write('message_type','success');
                $this->Session->write('message','Password Reset Successfully !');
            }else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','Invalid request, please try again !');  
            }
        }else{
            $this->Session->write('message_type','error');
            $this->Session->write('message','Invalid request, please try again !');  
        }
        $this->redirect(array('controller'=>'Users','action'=>'index'));
    } 
    /*
    * Forgot password
    */
    public function forgotpassword()
    {
         $this->layout = 'login';

        if($this->request->is('post')) {
           
            $mail = $this->request->data['User']['mail_id'];
            $data = $this->User->find('first', array('conditions'    => array(
                        'User.is_enable'    => 1,
                        'User.is_trash'     => 0,
                        'User.mail_id'      =>$mail,
                    )
            ));
            
            if(!$data) {
                
                $this->Session->write('message_type','error');
                $this->Session->write('message','Please enter valid email id or Email id not exists !');  
                

            } else {

                $key = $data['User']['reset_key'];
                $id = $data['User']['id'];
                $mail = $data['User']['mail_id'];
                $email = new CakeEmail('smtp');
                $email->to($mail);
                $email->from("g.satyanarayan@lipl.in");
                $email->emailFormat('html');
                $email->subject('Password reset instructions from');
                $email->viewVars(array('key'=>$key,'id'=>$id,'rand'=> mt_rand()));
                $email->template('reset');
                if($email->send('reset')) {
                
                $this->Session->write('message_type','success');
                $this->Session->write('message','Please check your email for reset instructions. !');  
                $this->redirect('/');
                } else {
                $this->Session->write('message_type','error');
                $this->Session->write('message','Something went wrong with  mail. Please try later. !');  
                
                }
            }
           
        }


    }
    /*
    *Method to reset the password 
    */
    public function reset($access_key)
    {
         $this->layout = 'login';
         $this->loadModel('User');
         //debug($access_key);
       // $a = $access_key;

        if($access_key)
        {
           // debug($a);
        $keyPair = $access_key;
        $key = explode('BXX', $keyPair);
        $pair = explode('XXB',$key[1]);
        $key = $key[0];
        $pair = $pair[1];
        $password="";
            
        if(isset($this->data['User']['password']) && $this->data['User']['password']!='')
        {
            
        $password = $this->request->data['User']['password'];
        unset($this->request->data['User']['password']);  
        unset($this->request->data['User']['re_password']);  
        
       
        $uArr = $this->User->findById($pair);
        if($uArr['User']['reset_key'] == $key) {
           
        $this->User->read(null, $pair);
        $this->User->set('password', $password);
        if($this->User->save()) { 
        $this->Session->write('message_type','success');
        $this->Session->write('message','Password reset successful!');  
        $this->redirect('/');
        } else {
        $this->Session->write('message_type','error');
        $this->Session->write('message','Password Reset link is broken or Expired  ! Try to forgot pasword'); 
        }
        }
         else {
        $this->Session->write('message_type','error');
        $this->Session->write('message','Password Reset link is broken or Expired  ! Try to forgot pasword'); 
         } 
        }

      }

    else{
        $this->Session->write('message_type','error');
        $this->Session->write('message','Password Reset link is broken or Expired  ! Try to forgot pasword');  

        }
}

/*
 * Query for get the state wise district
 */            
    public function getDistrict(){
        $this->autoRender = false;
        if(isset($this->data['state_id']) && (int)$this->data['state_id'] != 0){
            $districtList = $this->District->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'District.id',
                    'District.name',
                ),
                'conditions'    => array(
                    'District.state_id'     => $this->data['state_id'],
                    'District.is_enable'    => 1,
                    'District.is_trash'     => 0
                ),
                'order'         => array(
                    'District.name'
                ),
            ));
            if(is_array($districtList) && count($districtList)>0){
                echo '<option value="">-- Select District --</option>';
                foreach($districtList as $distKey=>$distVal){
                    echo '<option value="'.$distKey.'">'.$distVal.'</option>';
                }
            }else{
                echo '<option value="">-- Select District --</option>';
            }
        }else{
            echo '<option value="">-- Select District --</option>';
        }
    }
}