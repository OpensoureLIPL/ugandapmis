<?php
App::uses('AppController', 'Controller');
class EarningsController   extends AppController {
    public $layout='table';
    public $uses=array('Prisoner','Earning','WorkingPartyPrisoner','WorkingParty','Item','PurchaseItem','PrisonerAttendance','PrisonerPaysheet', 'EarningRatePrisoner','EarningRate');
    public function index(){

        $this->request->data['Search']['start_date'] = date('Y-m-d'); 
        $this->request->data['Search']['end_date'] = date('Y-m-d');
        
        $prison_id = $this->Session->read('Auth.User.prison_id');
        //get working party list
        $workingPartyList = $this->WorkingParty->find('list', array(
            //'recursive'     => -1,
            'fields'        => array(
                'WorkingParty.id',
                'WorkingParty.name',
            ),
            'conditions'    => array(
                'WorkingParty.is_enable'      => 1,
                'WorkingParty.is_trash'       => 0,
                'WorkingParty.prison_id'       => $prison_id
            ),
            'order'         => array(
                'WorkingParty.name'
            ),
        ));
        //echo '<pre>'; print_r($workingPartyList); exit;
        $this->set(array(
            'workingPartyList'    => $workingPartyList
        ));
                
     }
     public function indexAjax()
     {
        $this->layout   = 'ajax';
        $prison_id = $this->Session->read('Auth.User.prison_id');

        $from_date = $to_date = date('Y-m-d');

        $condition = array(

            //'PrisonerAttendance.prison_id' => $prison_id,
        );

        //echo '<pre>'; print_r($this->data); exit;
        if(isset($this->params['named']['from_date']) && $this->params['named']['from_date'] != ''){

            $from_date = $this->params['named']['from_date'];
            $from_date = date('Y-m-d', strtotime($from_date));
            $condition += array('PrisonerAttendance.attendance_date >=' => $from_date );
        }
        if(isset($this->params['named']['to_date']) && $this->params['named']['to_date'] != ''){

            $to_date = date('Y-m-d', strtotime($to_date));
            $to_date = $this->params['named']['to_date'];
            $condition += array('PrisonerAttendance.attendance_date <=' => $to_date );
        }
        if(isset($this->params['named']['working_party_id']) && $this->params['named']['working_party_id'] != ''){

            $working_party_id = $this->params['named']['working_party_id'];
            $condition += array('PrisonerAttendance.working_party_id' => $working_party_id );
        }

        //get prisoners list based on working party 
        
        
        $limit = array('limit'  => 20);
                     
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         => array(
                'PrisonerAttendance.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerAttendance');

        $this->set(array(
            'datas'         => $datas, 
            'start_date'     => $from_date,
            'end_date'       => $to_date
        ));

     }
     //Module: Earning Working Parties -- START --
     //Author: Itishree
     //Date  : 12-09-2017
     public function  workingParties()
     {
          if($this->request->is(array('post','put'))){

               //echo '<pre>'; print_r($this->request->data); exit;

               if(isset($this->request->data['workingPartyEdit']['id']))
               {
                    $this->request->data  = $this->WorkingParty->findById($this->request->data['workingPartyEdit']['id']);
               }   
               else 
               {
                    $login_user_id = $this->Session->read('Auth.User.id');   
                    $this->request->data['WorkingParty']['login_user_id'] = $login_user_id;
                    $this->request->data['WorkingParty']['start_date']=date('Y-m-d',strtotime($this->request->data['WorkingParty']['start_date']));
                    //create uuid
                    if(empty($this->request->data['WorkingParty']['id']))
                    {
                         $uuid = $this->WorkingParty->query("select uuid() as code");
                         $uuid = $uuid[0][0]['code'];
                         $this->request->data['WorkingParty']['uuid'] = $uuid;
                    }  
                    if($this->WorkingParty->save($this->request->data)){
                         $this->Session->write('message_type','success');
                         $this->Session->write('message','Saved Successfully !');
                         $this->redirect(array('action'=>'workingParties'));
                    }
                    else{
                         $this->Session->write('message_type','error');
                         $this->Session->write('message','Saving Failed !'); 
                    }
               }  
        }
     }
     //Working party ajax listing 
     public function workingPartyAjax(){
        $this->layout   = 'ajax';
        $prison_id      = '';
        $condition      = array(
            'WorkingParty.is_trash'         => 0,
        );
        $prison_id = $this->Session->read('Auth.User.prison_id');
        
        $condition += array('WorkingParty.prison_id' => $prison_id );
        
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
                'WorkingParty.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('WorkingParty');
        $this->set(array(
            'datas'         => $datas,  
            'prison_id'=>$prison_id    
        ));
     }
     //Delete Working Party 
     function deleteWorkingParty()
     {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'WorkingParty.is_trash'    => 1,
            );
            $conds = array(
                'WorkingParty.id'    => $uuid,
            );
            
            if($this->WorkingParty->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     //Earning Working Parties -- END --
     //Assign working party prisoner -- START --
     public function assignPrionsers()
     {
          //get current prison id
          $prison_id = $this->Session->read('Auth.User.prison_id');

          if($this->request->is(array('post','put'))){

               //echo '<pre>'; print_r($this->request->data); exit;

               if(isset($this->request->data['workingPartyPrisonerEdit']['id']))
               { 
                    $this->request->data = $this->WorkingPartyPrisoner->findById($this->request->data['workingPartyPrisonerEdit']['id']);
               }   
               else 
               { 
                    $login_user_id = $this->Session->read('Auth.User.id');   
                    $this->request->data['WorkingPartyPrisoner']['login_user_id'] = $login_user_id;
                    if(!empty($this->request->data['WorkingPartyPrisoner']['assignment_date']))
                         $this->request->data['WorkingPartyPrisoner']['assignment_date']=date('Y-m-d',strtotime($this->request->data['WorkingPartyPrisoner']['assignment_date']));
                    if(!empty($this->request->data['WorkingPartyPrisoner']['start_date']))
                         $this->request->data['WorkingPartyPrisoner']['start_date']=date('Y-m-d',strtotime($this->request->data['WorkingPartyPrisoner']['start_date']));
                    if(!empty($this->request->data['WorkingPartyPrisoner']['end_date']))
                         $this->request->data['WorkingPartyPrisoner']['end_date']=date('Y-m-d',strtotime($this->request->data['WorkingPartyPrisoner']['end_date']));
                    //create uuid
                    if(empty($this->request->data['WorkingPartyPrisoner']['id']))
                    {
                         $uuid = $this->WorkingPartyPrisoner->query("select uuid() as code");
                         $uuid = $uuid[0][0]['code'];
                         $this->request->data['WorkingPartyPrisoner']['uuid'] = $uuid;
                    }  
                    if($this->WorkingPartyPrisoner->save($this->request->data)){
                         $this->Session->write('message_type','success');
                         $this->Session->write('message','Saved Successfully !');
                         $this->redirect(array('action'=>'assignPrionsers'));
                    }
                    else{
                         $this->Session->write('message_type','error');
                         $this->Session->write('message','Saving Failed !'); 
                    }
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
                'Prisoner.is_trash'       => 0,
                'Prisoner.prison_id'       => $prison_id
            ),
            'order'         => array(
                'Prisoner.prisoner_no'
            ),
        ));
        //get working party list
          $workingPartyList = $this->WorkingParty->find('list', array(
            //'recursive'     => -1,
            'fields'        => array(
                'WorkingParty.id',
                'WorkingParty.name',
            ),
            'conditions'    => array(
                'WorkingParty.is_enable'      => 1,
                'WorkingParty.is_trash'       => 0,
                'WorkingParty.prison_id'       => $prison_id
            ),
            'order'         => array(
                'WorkingParty.name'
            ),
        ));
        //echo '<pre>'; print_r($workingPartyList); exit;
        $this->set(array(
            'workingPartyList'    => $workingPartyList,
            'prisonerList'    => $prisonerList
        ));
     }
     //Working party ajax listing 
     public function workingPartyPrisonerAjax(){

        $this->layout   = 'ajax';
        $prison_id      = '';
        $condition      = array(
            'WorkingPartyPrisoner.is_trash'         => 0,
        );
        $prison_id = $this->Session->read('Auth.User.prison_id');
        
        $condition += array('WorkingPartyPrisoner.prison_id' => $prison_id );
        
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
                'WorkingPartyPrisoner.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('WorkingPartyPrisoner');
        $this->set(array(
            'datas'         => $datas,  
            'prison_id'=>$prison_id    
        ));
     }
     //Delete Working party prisoner
     function deleteWorkingPartyPrisoner()
     {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'WorkingPartyPrisoner.is_trash'    => 1,
            );
            $conds = array(
                'WorkingPartyPrisoner.id'    => $uuid,
            );
            
            if($this->WorkingPartyPrisoner->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     //Assign working party prisoner -- END --
     public function attendances()
     {
          $prison_id = $this->Session->read('Auth.User.prison_id');
          $login_user_id = $this->Session->read('Auth.User.id');

          if($this->request->is(array('post','put'))){
               
               if(isset($this->request->data['PrisonerAttendanceData']['id']))
               { 
                    //$this->request->data = $this->PrisonerAttendance->findById($this->request->data['PrisonerAttendanceEdit']['id']);
               }   
               else 
               { 
                    $attendance_date = $this->request->data['Attendance']['attendance_date'];
                    $this->request->data['Search']['attendance_date'] = date('d-m-Y', strtotime($this->request->data['Attendance']['attendance_date']));
                    $this->request->data['Search']['working_party_id'] = $this->request->data['Attendance']['working_party_id'];
                    $prisonerAttendances = '';
                    if(isset($this->request->data['PrisonerAttendance']))
                        $prisonerAttendances = $this->request->data['PrisonerAttendance'];
                    $attendanceData = $this->request->data['Attendance'];
                    unset($this->request->data['Attendance']);
                    unset($this->request->data['PrisonerAttendance']);

                    //echo '<pre>'; print_r($prisonerAttendances); exit;
                    
                    if(!empty($prisonerAttendances) && count($prisonerAttendances) > 0)
                    {
                        $conds = array(
                            'PrisonerAttendance.prison_id'    => $prison_id,
                            'PrisonerAttendance.attendance_date'    => $attendance_date,
                            'PrisonerAttendance.working_party_id'    => $this->request->data['Search']['working_party_id']
                        );
                        
                        $this->PrisonerAttendance->deleteAll($conds);
                        $cnt = 0;
                        foreach($prisonerAttendances as $prisonerAttendance)
                        {
                            $prisonerAttendanceData = '';
                            $prisonerAttendanceData['PrisonerAttendance'] = $attendanceData;

                            //get price per work of prisoner 
                            $earningRates = $this->EarningRatePrisoner->find('first', array(
                
                                'conditions'    => array(

                                    'EarningRatePrisoner.is_trash' => 0,
                                    'EarningRatePrisoner.prisoner_id'   => $prisonerAttendance['prisoner_id'],
                                    'EarningRate.start_date <=' => $attendance_date,
                                    'EarningRate.end_date >=' => $attendance_date
                                )
                            ));
                            $amount = 0;
                            if(isset($earningRates['EarningRate']['amount']))
                                $amount = $earningRates['EarningRate']['amount'];
                            $prisonerAttendanceData['PrisonerAttendance']['amount'] = $amount;                            

                            $uuid = $this->PrisonerAttendance->query("select uuid() as code");
                            $uuid = $uuid[0][0]['code'];
                            $prisonerAttendanceData['PrisonerAttendance']['uuid'] = $uuid;
                            $prisonerAttendanceData['PrisonerAttendance']['prisoner_id'] = $prisonerAttendance['prisoner_id'];
                            $prisonerAttendanceData['PrisonerAttendance']['login_user_id'] = $login_user_id;
                                                        
                            if($this->PrisonerAttendance->saveAll($prisonerAttendanceData))
                            {
                                $cnt = $cnt+1;
                            }
                        }
                        if($cnt == count($prisonerAttendances))
                        {
                            $this->Session->write('message_type','success');
                            $this->Session->write('message','Saved Successfully !');
                        }
                        
                    }
                    else 
                    {
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed ! No Prisoner selected !'); 
                    }
               }  
            }

          //get working party list
          $workingPartyList = $this->WorkingParty->find('list', array(
            //'recursive'     => -1,
            'fields'        => array(
                'WorkingParty.id',
                'WorkingParty.name',
            ),
            'conditions'    => array(
                'WorkingParty.is_enable'      => 1,
                'WorkingParty.is_trash'       => 0,
                'WorkingParty.prison_id'       => $prison_id
            ),
            'order'         => array(
                'WorkingParty.name'
            ),
        ));
        
        $this->set(array(
            'workingPartyList'    => $workingPartyList
        ));
        //$this->request['Search']['attendance_date'] = date('d-m-Y');
        //echo '<pre>'; print_r($this->request); exit;
     }
     public function prisonerearnings()
     {

     }
     // create article/item -- START --
     public function createarticle()
     {
        if($this->request->is(array('post','put'))){

           if(isset($this->request->data['itemEdit']['id']))
           {
                $this->request->data  = $this->Item->findById($this->request->data['itemEdit']['id']);
           }   
           else 
           {
                $login_user_id = $this->Session->read('Auth.User.id');   
                $this->request->data['Item']['login_user_id'] = $login_user_id;
                //create uuid
                if(empty($this->request->data['Item']['id']))
                {
                     $uuid = $this->Item->query("select uuid() as code");
                     $uuid = $uuid[0][0]['code'];
                     $this->request->data['Item']['uuid'] = $uuid;
                }  
                if($this->Item->save($this->request->data)){
                     $this->Session->write('message_type','success');
                     $this->Session->write('message','Saved Successfully !');
                     $this->redirect(array('action'=>'createarticle'));
                }
                else{
                     $this->Session->write('message_type','error');
                     $this->Session->write('message','Saving Failed !'); 
                }
           }  
        }
     }
     //Item ajax listing 
     public function itemAjax(){
        $this->layout   = 'ajax';
        $prison_id      = '';
        $condition      = array(
            'Item.is_trash'         => 0,
        );
        $prison_id = $this->Session->read('Auth.User.prison_id');
        
        $condition += array('Item.prison_id' => $prison_id );
        
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
                'Item.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('Item');
        $this->set(array(
            'datas'         => $datas,  
            'prison_id'=>$prison_id    
        ));
     }
     //Delete Item
     function deleteItem()
     {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'Item.is_trash'    => 1,
            );
            $conds = array(
                'Item.id'    => $uuid,
            );
            
            if($this->Item->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     // create article/item -- END --
     public function itemReceivedByPriosner()
     {
        $prison_id = $this->Session->read('Auth.User.prison_id');
        if($this->request->is(array('post','put'))){

           if(isset($this->request->data['PurchaseItemEdit']['id']))
           {
                $this->request->data  = $this->PurchaseItem->findById($this->request->data['PurchaseItemEdit']['id']);
                if(!empty($this->request->data['PurchaseItem']['item_rcv_date']))
                    $this->request->data['PurchaseItem']['item_rcv_date']=date('d-m-Y',strtotime($this->request->data['PurchaseItem']['item_rcv_date']));
           }   
           else 
           {
                $login_user_id = $this->Session->read('Auth.User.id');   
                $this->request->data['PurchaseItem']['login_user_id'] = $login_user_id;

                if(!empty($this->request->data['PurchaseItem']['item_rcv_date']))
                    $this->request->data['PurchaseItem']['item_rcv_date']=date('Y-m-d',strtotime($this->request->data['PurchaseItem']['item_rcv_date']));

                //create uuid
                if(empty($this->request->data['PurchaseItem']['id']))
                {
                     $uuid = $this->PurchaseItem->query("select uuid() as code");
                     $uuid = $uuid[0][0]['code'];
                     $this->request->data['PurchaseItem']['uuid'] = $uuid;
                }  
                if($this->PurchaseItem->save($this->request->data)){
                     $this->Session->write('message_type','success');
                     $this->Session->write('message','Saved Successfully !');
                     $this->redirect(array('action'=>'itemReceivedByPriosner'));
                }
                else{
                     $this->Session->write('message_type','error');
                     $this->Session->write('message','Saving Failed !'); 
                }
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
                'Prisoner.is_trash'       => 0,
                'Prisoner.prison_id'       => $prison_id
            ),
            'order'         => array(
                'Prisoner.prisoner_no'
            ),
        ));
        //get item list
          $itemList = $this->Item->find('list', array(
            //'recursive'     => -1,
            'fields'        => array(
                'Item.id',
                'Item.name',
            ),
            'conditions'    => array(
                'Item.is_enable'      => 1,
                'Item.is_trash'       => 0,
                'Item.prison_id'       => $prison_id
            ),
            'order'         => array(
                'Item.name'
            ),
        ));
        $this->set(array(
            'itemList'    => $itemList,
            'prisonerList'    => $prisonerList
        ));
     }
     //Purchased Item ajax listing 
     public function purchaseItemAjax(){
        $this->layout   = 'ajax';
        $prison_id      = '';
        $condition      = array(
            'PurchaseItem.is_trash'         => 0,
        );
        $prison_id = $this->Session->read('Auth.User.prison_id');
        
        $condition += array('PurchaseItem.prison_id' => $prison_id );
        
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
                'PurchaseItem.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PurchaseItem');
        $this->set(array(
            'datas'         => $datas,  
            'prison_id'=>$prison_id    
        ));
     }
     //Delete Purchased Item
     function deletePurchaseItem()
     {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PurchaseItem.is_trash'    => 1,
            );
            $conds = array(
                'PurchaseItem.id'    => $uuid,
            );
            
            if($this->PurchaseItem->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     public function paysheet()
     {
        $prison_id = $this->Session->read('Auth.User.prison_id');

          if($this->request->is(array('post','put'))){

               //echo '<pre>'; print_r($this->request->data); exit;

               if(isset($this->request->data['PrisonerPaysheetEdit']['id']))
               { 
                    $this->request->data = $this->PrisonerPaysheet->findById($this->request->data['PrisonerPaysheetEdit']['id']);

                    //get prisoner balance 
               }   
               else 
               { 
                    //echo '<pre>'; print_r($this->request->data); exit;
                    $this->request->data['PrisonerPaysheet']['date_of_pay'] = date('Y-m-d', strtotime($this->request->data['PrisonerPaysheet']['date_of_pay']));

                    $login_user_id = $this->Session->read('Auth.User.id');   
                    $this->request->data['PrisonerPaysheet']['login_user_id'] = $login_user_id;
                    
                    //create uuid
                    if(empty($this->request->data['PrisonerPaysheet']['id']))
                    {
                         $uuid = $this->PrisonerPaysheet->query("select uuid() as code");
                         $uuid = $uuid[0][0]['code'];
                         $this->request->data['PrisonerPaysheet']['uuid'] = $uuid;
                    }  
                    if($this->PrisonerPaysheet->save($this->request->data)){
                         $this->Session->write('message_type','success');
                         $this->Session->write('message','Saved Successfully !');
                         $this->redirect(array('action'=>'paysheet'));
                    }
                    else{
                         $this->Session->write('message_type','error');
                         $this->Session->write('message','Saving Failed !'); 
                    }
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
                'Prisoner.is_trash'       => 0,
                'Prisoner.prison_id'       => $prison_id
            ),
            'order'         => array(
                'Prisoner.prisoner_no'
            ),
        ));
        $this->set(array(
            'prisonerList'    => $prisonerList
        ));
     }
     public function prisonerPaysheetAjax(){
        $this->layout   = 'ajax';
        $prison_id      = '';
        $condition      = array(
            'PrisonerPaysheet.is_trash'         => 0,
        );
        $prison_id = $this->Session->read('Auth.User.prison_id');
        
        $condition += array('PrisonerPaysheet.prison_id' => $prison_id );
        
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
                'PrisonerPaysheet.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerPaysheet');
        $this->set(array(
            'datas'         => $datas,  
            'prison_id'=>$prison_id    
        ));
     }
     //Delete Purchased Item
     function deletePrisonerPaysheet()
     {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerPaysheet.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerPaysheet.id'    => $uuid,
            );
            
            if($this->PrisonerPaysheet->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
    //get price on item change -- START --
    public function getItemPrice()
    {
        $this->autoRender = false;
        $item_id = $this->request->data['item_id'];
        $price = '0';
        if(isset($item_id) && (int)$item_id != 0)
        {
            $item = $this->Item->findById($item_id);
            $price = $item['Item']['price'];
        }
        echo $price;  
    }
    //get price on item change -- END --  
    function showPrisoners()
    {
        $this->layout   = 'ajax';
        $attendance_date = date('Y-m-d');
        $working_party_id = '';
        $prison_id = $this->Session->read('Auth.User.prison_id');
        //$attendance_date = $this->data['Search']['attendance_date'];
        //$working_party_id = $this->data['Search']['working_party_id'];
        //echo '<pre>'; print_r($this->params); exit;
        if(isset($this->params['data']['attendance_date']))
            $attendance_date = $this->params['data']['attendance_date'];

        if(isset($this->params['data']['working_party_id']))
            $working_party_id = $this->params['data']['working_party_id'];

        $condition      = array(
            'WorkingPartyPrisoner.is_trash'         => 0,
            'WorkingPartyPrisoner.is_enable'        => 1,
            'WorkingPartyPrisoner.prison_id'        => $prison_id,
        );
        if($attendance_date != '')
        {
            $attendance_date = date('Y-m-d', strtotime($attendance_date));
            $condition      += array(
                'WorkingPartyPrisoner.start_date <='    => $attendance_date,
                'WorkingPartyPrisoner.end_date >='    => $attendance_date,
            ); 
        }
        if($working_party_id != '')
        {
            $condition      += array(
                'WorkingPartyPrisoner.working_party_id'    => $working_party_id,
            ); 
        }
        $limit = array('limit'  => 20);
                     
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         => array(
                'WorkingPartyPrisoner.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('WorkingPartyPrisoner');

        //get prisoner attendance 
        $prisonerAttendanceList = $this->PrisonerAttendance->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'PrisonerAttendance.prisoner_id',
            ),
            'conditions'    => array(
                'PrisonerAttendance.attendance_date'      => $attendance_date,
                'PrisonerAttendance.working_party_id' => $working_party_id,
                'PrisonerAttendance.prison_id'       => $prison_id
            ),
            'order'         => array(
                'PrisonerAttendance.id'
            ),
        ));

        $this->set(array(
            'datas'         => $datas,  
            'prisonerAttendanceList'         => $prisonerAttendanceList,  
            'prison_id'=>$prison_id,
            'attendance_date' =>  $attendance_date,
            'working_party_id' =>   $working_party_id  
        ));
        //echo '<pre>'; print_r($datas); exit;
    }
    //get prisoner info on prisoner change -- START --
    public function getPrisonerInfo()
    {
        $this->autoRender = false;
        $prisoner_id = $this->request->data['prisoner_id'];
        $data = '';
        if(isset($prisoner_id) && (int)$prisoner_id != 0)
        {
            $prisonerData = $this->Prisoner->findById($prisoner_id);
            $data['prisoner_name'] = $prisonerData['Prisoner']['fullname'];

            //get prisoner balance 
            $amount = $this->getPrisonerBalance($prisoner_id);
            
            $data['balance'] = $amount;
        }
        echo json_encode($data);exit;
    }
 }