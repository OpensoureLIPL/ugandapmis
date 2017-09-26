<?php
App::uses('AppController', 'Controller');
class PhysicallockupsController   extends AppController {
    public $layout='table';
    public $uses=array('PhysicalLockup','LockupType','PrisonerType','User');
    public function index()
    {
        /*
        *code add the Physical Lockups 
        */
      if(isset($this->data['PhysicalLockup']) && is_array($this->data['PhysicalLockup']) && $this->data['PhysicalLockup']!='')
        {
             if(isset($this->data['PhysicalLockup']['uuid']) && $this->data['PhysicalLockup']['uuid']=='')
             { 
                $uuidArr=$this->PhysicalLockup->query("select uuid() as code");
                $this->request->data['PhysicalLockup']['uuid']=$uuidArr[0][0]['code'];
             }  
             if(isset($this->data['PhysicalLockup']['lock_date']) && $this->data['PhysicalLockup']['lock_date']!="" )
             {
                $this->request->data['PhysicalLockup']['lock_date']=date('Y-m-d',strtotime($this->data['PhysicalLockup']['lock_date']));
             }
         
            //get the current user id
            $user_id=$this->Auth->user('id');
            //To get the  prison id of the user
            $user=$this->User->find('first',array(
                    'conditions'=>array(
                      'User.id'=>$user_id
                    ),
            ));

           $this->request->data['PhysicalLockup']['prison_id']=$user['User']['prison_id'];//Assigned prison id 
           $this->request->data['PhysicalLockup']['user_id']=$user_id;//Assigned user id to
             if($this->PhysicalLockup->save($this->data))
             {
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved successfully');
                $this->redirect('/physicallockups');
             }
             else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','saving failed');
                }
             
            
         }

        /*
         *Code for edit the PhysicalLockup 
         */
        if(isset($this->data['PhysicalLockupEdit']['id']) && (int)$this->data['PhysicalLockupEdit']['id'] != 0){
            if($this->PhysicalLockup->exists($this->data['PhysicalLockupEdit']['id'])){
                $this->data = $this->PhysicalLockup->findById($this->data['PhysicalLockupEdit']['id']);
            }
        }

         $lockupTypeList=$this->LockupType->find('list',array(
                        'recursive'     => -1,
                        'fields'        => array(
                            'LockupType.id',
                            'LockupType.name',
                        ),
                        'conditions'    => array(
                            'LockupType.is_enable'    => 1,
                            'LockupType.is_trash'     => 0,
                        ),
                        'order'=>array(
                            'LockupType.name'
                        )
                    ));   
         $prisonerTypeList=$this->PrisonerType->find('list',array(
                        'recursive'     => -1,
                        'fields'        => array(
                            'PrisonerType.id',
                            'PrisonerType.name',
                        ),
                        'conditions'    => array(
                            'PrisonerType.is_enable'    => 1,
                            'PrisonerType.is_trash'     => 0,
                        ),
                        'order'=>array(
                            'PrisonerType.name'
                        )
                    ));    
         
          $this->set(compact('lockupTypeList','prisonerTypeList'));
    }
    public function indexAjax()
     {
        $this->layout='ajax';
        $condition= array('PhysicalLockup.is_trash'=>0);

        $this->paginate=array(
            'conditions' =>$condition,
             'order'     => array(
              'PhysicalLockup.modified'=>'DESC' 
              ),
             
            'limit'     =>20
            );

         $datas=$this->paginate('PhysicalLockup');
         $this->set(array(
                'datas' =>$datas
            ));

     }
     public function lockupReport()
     {
        $from=date('Y-m-d');
        $data=array('Search'=>array('from' => $from)
        );
        $this->set($data); 
     }
     public function lockupReportAjax()
     {
        $this->layout = 'ajax';
        $from=date('Y-m-d');
        $datas=array();
        if(isset($this->params['named']['from']) && $this->params['named']['from'] != '')
        {
             $from=$this->params['named']['from'];
        }
       $lockupTypeList=$this->LockupType->find('all',array(
                        'recursive'     => -1,
                        'fields'        => array(
                            'LockupType.id',
                            'LockupType.name',
                        ),
                        'conditions'    => array(
                            'LockupType.is_enable'    => 1,
                            'LockupType.is_trash'     => 0,
                        ),
                        'order'=>array(
                            'LockupType.name'
                        )
                    ));   
       foreach($lockupTypeList as $row)
       {
            
           $datas[$row['LockupType']['name']]=$this->getlockupReport($from,$row['LockupType']['id']);

       }
      
        $this->set(array(
            'datas'         => $datas,  
            'from'          => $from,
        )); 
     }
     //To get the lockup report 
     private function getlockupReport($from,$locktype)
      {
        return $this->PhysicalLockup->query("SELECT prisoner_types.name AS prisoner_type,SUM(no_of_male) AS males,SUM(no_of_female) AS female  FROM physical_lockups
          JOIN prisoner_types ON physical_lockups.prisoner_type_id=prisoner_types.id 
          WHERE lock_date='".$from."' AND lockup_type_id='".$locktype."'
           GROUP BY prisoner_types.name");
      }
     


 }