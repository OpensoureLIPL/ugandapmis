<?php
App::uses('AppController', 'Controller');
class PrisonerTransfersController   extends AppController {
    public $layout='table';
    public $uses=array('Prisoner','Prison','PrisonerTransfer','PrisonerAdmissionDetail','PrisonerIdDetail','PrisonerKinDetail','PrisonerChildDetail','PrisonerSentenceDetail','PrisonerSpecialNeed','PrisonerOffenceDetail','PrisonerOffenceCount','PrisonerRecaptureDetail','PrisonerChildDetail','MedicalDeathRecord','MedicalSeriousIllRecord','MedicalCheckupRecord','MedicalDeathRecord','StagePromotion','StageDemotion','StageReinstatement','InPrisonOffenceCapture','InPrisonPunishment');
    //Module: Prisoner Transfer -- START --
    //Author: Itishree
    //Date  : 13-09-2017
    public function index($transfer_type='outgoing'){
        
        $prison_id = $this->Session->read('Auth.User.prison_id');
        $usertype_id = $this->Session->read('Auth.User.usertype_id');
        $login_user_id = $this->Session->read('Auth.User.id');

        //check prisoner existance 
        $prisonData = $this->Prison->findById($prison_id);
        //proceed if prisoner exis
        if(isset($prisonData['Prison']['id']) && !empty($prisonData['Prison']['id']))
        {
            //Save Prisoner Transfer 
            if($this->request->is(array('post','put'))){

                if(isset($this->request->data['PrisonerTransferEdit']['id']))
                { 
                    $this->request->data = $this->PrisonerTransfer->findById($this->request->data['PrisonerTransferEdit']['id']);
                }   
                else
                {
                    if(!empty($this->request->data['PrisonerTransfer']['transfer_date']))
                    {
                        $this->request->data['PrisonerTransfer']['transfer_date']=date('Y-m-d',strtotime($this->request->data['PrisonerTransfer']['transfer_date']));
                    }
                    $this->request->data['PrisonerTransfer']['created_by'] = $login_user_id;
                    //create uuid
                    $transfer_action = 'edit';
                    if(empty($this->request->data['PrisonerTransfer']['id']))
                    {
                        $transfer_action = 'add';
                        $uuid = $this->PrisonerTransfer->query("select uuid() as code");
                        $uuid = $uuid[0][0]['code'];
                        $this->request->data['PrisonerTransfer']['uuid'] = $uuid;
                        $prisoner_id = $this->request->data['PrisonerTransfer']['prisoner_id'];
                    } 
                    //Save Prisoner Transfer Data 
                    if($this->PrisonerTransfer->save($this->request->data)){

                        if($transfer_action == 'add')
                        {
                            $transfer_id = $this->PrisonerTransfer->id;
                            $pfields = array(
                                'Prisoner.transfer_status' => "'Process'",
                                'Prisoner.transfer_id'     =>  $transfer_id
                            );
                            $pconds = array(
                                'Prisoner.id'     => $prisoner_id
                            );
                            $this->Prisoner->updateAll($pfields, $pconds);
                        }


                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('action'=>'/index'));
                    }
                    else{
                         $this->Session->write('message_type','error');
                         $this->Session->write('message','Saving Failed !'); 
                    }
                }
            }
            //get prisoner list
            $prisonList = $this->Prison->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'Prison.id',
                    'Prison.name',
                ),
                'conditions'    => array(
                    'Prison.is_enable'      => 1,
                    'Prison.is_trash'       => 0,
                    'Prison.id !='       => $prison_id
                ),
                'order'         => array(
                    'Prison.name'
                ),
            ));
            //get prisoner list
            if($usertype_id == 5) 
            {
                if($transfer_type == 'outgoing')
                {
                    $conditions = array(
                            'Prisoner.is_enable'      => 1,
                            'Prisoner.is_trash'       => 0,
                            'Prisoner.prison_id'      => $prison_id,
                            'OR' => array(
                                array('Prisoner.transfer_status'=> 'Deleted'),
                                array('Prisoner.transfer_status'=> 'Rejected'),
                                array('Prisoner.transfer_id'    => 0)
                            )
                    );
                    if(!empty($this->request->data['PrisonerTransfer']['id']))
                    {
                       $conditions = array(
                            'Prisoner.is_enable'      => 1,
                            'Prisoner.is_trash'       => 0,
                            'Prisoner.prison_id'      => $prison_id,
                            'OR' => array(
                                array('Prisoner.transfer_status'=> 'Process'),
                                array('Prisoner.transfer_status'=> 'Deleted'),
                                array('Prisoner.transfer_status'=> 'Rejected'),
                                array('Prisoner.transfer_id'    => 0)
                            )
                        ); 
                    }
                    $prisonerList = $this->Prisoner->find('list', array(
                        'recursive'     => -1,
                        'fields'        => array(
                            'Prisoner.id',
                            'Prisoner.prisoner_no',
                        ),
                        'conditions'    => $conditions,
                        'order'         => array(
                            'Prisoner.prisoner_no'
                        ),
                    ));
                }
                else 
                {
                    $conditions = array(
                        'Prisoner.is_enable'      => 1,
                        //'Prisoner.is_trash'       => 0,
                        'PrisonerTransfer.transfer_to_station_id' => $prison_id,
                        'OR' => array(
                           array('PrisonerTransfer.status' => 'Approved'),
                            array('PrisonerTransfer.status' => 'Recieved')
                        )
                    );

                    $prisonerList = $this->PrisonerTransfer->find('list', array(
                    
                        'joins' => array(
                            array(
                                'table' => 'prisoners',
                                'alias' => 'Prisoner',
                                'type' => 'left',
                                'conditions'=> array('PrisonerTransfer.prisoner_id = Prisoner.id'),
                            ),
                        ),
                        'fields'        => array(
                            'PrisonerTransfer.prisoner_id',
                            'Prisoner.prisoner_no',
                        ),
                        'conditions'    => $conditions,
                        'order'         => array(
                            'PrisonerTransfer.prisoner_id'
                        ),
                    ));
                    //echo '<pre>'; print_r($prisonerList); exit;
                }
            }
            else 
            {
               $transfer_status = 'Reviewed';

                if($transfer_type == 'outgoing')
                {
                    $conditions = array(
                        'Prisoner.is_enable'      => 1,
                        'Prisoner.is_trash'       => 0,
                        'PrisonerTransfer.transfer_from_station_id' => $prison_id
                    );
                }
                else 
                {
                    $conditions = array(
                        'Prisoner.is_enable'      => 1,
                        'PrisonerTransfer.transfer_to_station_id' => $prison_id,
                        'OR' => array(
                           array('PrisonerTransfer.status' => 'Approved'),
                            array('PrisonerTransfer.status' => 'Recieved')
                        )
                    );
                }

                $prisonerList = $this->PrisonerTransfer->find('list', array(
                    
                    'joins' => array(
                        array(
                            'table' => 'prisoners',
                            'alias' => 'Prisoner',
                            'type' => 'left',
                            'conditions'=> array('PrisonerTransfer.prisoner_id = Prisoner.id'),
                        ),
                    ),
                    'fields'        => array(
                        'PrisonerTransfer.prisoner_id',
                        'Prisoner.prisoner_no',
                    ),
                    'conditions'    => $conditions,
                    'order'         => array(
                        'PrisonerTransfer.prisoner_id'
                    ),
                ));
            }
            //get escorting officer list
            $escortingOfficerList = $this->User->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'User.id',
                    'User.name',
                ),
                'conditions'    => array(
                    'User.is_enable'    => 1,
                    'User.is_trash'     => 0,
                    'User.usertype_id'  => 3,
                    'User.prison_id'    => $prison_id
                ),
                'order'         => array(
                    'User.name'
                ),
            ));
            //echo '<pre>'; print_r($prisonerList); exit;
            //current prison station name 
            $current_prison_name = $prisonData['Prison']['name'].' ('.$prisonData['Prison']['code'].')';
            $statusList = array('On Progress','Verified', 'Approved', 'Recieved');
            $this->set(array(
                'prisonerList'  => $prisonerList,
                'prisonList'    => $prisonList,
                'usertype_id'   => $usertype_id,
                'transfer_type' => $transfer_type,
                'current_prison_name' => $current_prison_name,
                'escortingOfficerList'=> $escortingOfficerList
            ));
        }
        else 
        {
            $this->Session->write('message_type','error');
            $this->Session->write('message','Prison not exists !');
            $this->redirect(array('action'=>'../sites/dashboard'));
        }    
     }
     public function indexAjax()
     {
        $this->layout   = 'ajax';
        $prison_id = $this->Session->read('Auth.User.prison_id');
        $usertype_id = $this->Session->read('Auth.User.usertype_id');
        if(isset($this->request->data['transfer_type']))
            $transfer_type = $this->request->data['transfer_type'];
        if(isset($this->request->data['Search']['transfer_type']))
            $transfer_type = $this->request->data['Search']['transfer_type'];
        //echo $transfer_type; exit;

        $condition = array(
            'PrisonerTransfer.is_trash' => 0
        );

        if($transfer_type == 'outgoing')
        {
            $condition += array(
                'PrisonerTransfer.transfer_from_station_id' => $prison_id,
                //'PrisonerTransfer.status !=' => 'Recieved'
            );
            // if($usertype_id == 5)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.status' => 'Process'
            //     );
            // }
            // if($usertype_id == 4)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.instatus' => 'Saved'
            //     );
            // }
            // if($usertype_id == 3)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.status' => 'Reviewed'
            //     );
            // }
        }
        else 
        {
            $condition += array(
                'PrisonerTransfer.transfer_to_station_id' => $prison_id,
                 'OR' => array(
                    array('PrisonerTransfer.status' => 'Approved'),
                    array('PrisonerTransfer.status' => 'Recieved'),
                )
            );
            // if($usertype_id == 5)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.status' => 'Approved',
            //         'PrisonerTransfer.instatus' => 'Process'
            //     );
            // }
            // if($usertype_id == 4)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.status' => 'Approved',
            //         'PrisonerTransfer.instatus' => 'Recieved'
            //     );
            // }
            // if($usertype_id == 3)
            // {
            //     $condition += array(
            //         'PrisonerTransfer.status' => 'Approved',
            //         'PrisonerTransfer.instatus' => 'Reviewed'
            //     );
            // }
        }

        if(isset($this->request->data['Search']['prisoner_id']) && !empty($this->request->data['Search']['prisoner_id']))
        {
            $condition += array(
                'PrisonerTransfer.prisoner_id' => $this->request->data['Search']['prisoner_id']
            );
        }
        if(isset($this->request->data['Search']['transfer_date']) && !empty($this->request->data['Search']['transfer_date']))
        {
            $condition += array(
                'PrisonerTransfer.transfer_date' => date('Y-m-d', strtotime($this->request->data['Search']['transfer_date']))
            );
        }
        
        $limit = array('limit'  => 20);
                     
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         => array(
                'PrisonerTransfer.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerTransfer');
        //echo '<pre>'; print_r($condition); exit;

        $this->set(array(
            'datas'         => $datas, 
            'usertype_id'   => $usertype_id,
            'transfer_type' => $transfer_type
        ));

     }
     function deleteTransfer()
     {
         $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $transfer_id = $this->data['paramId'];
            $fields = array(
                'PrisonerTransfer.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerTransfer.id'    => $transfer_id,
            );
            
            if($this->PrisonerTransfer->updateAll($fields, $conds)){
                //update prisoner transfer info 
                $pfields = array(
                    'Prisoner.transfer_status' => "'Deleted'"
                    
                );
                $pconds = array(
                    'Prisoner.transfer_id'  =>  $transfer_id
                );
                $this->Prisoner->updateAll($pfields, $pconds);
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     function forwardTransfer()
     {
         $this->autoRender = false;
         $usertype_id = $this->Session->read('Auth.User.usertype_id');
         $login_user_id = $this->Session->read('Auth.User.id');
         if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $status = $this->data['status'];
            $fields = array(
                'PrisonerTransfer.status'    => "'$status'",
            );
            $cdate = date('Y-m-d');
            if($status == 'Rejected')
            {
                $fields += array(
                    'PrisonerTransfer.rejected_date'    => "'$cdate'",
                    'PrisonerTransfer.rejected_by'    => $login_user_id
                );
            }
            else
            {
                if($usertype_id == 5)
                {
                    $fields += array(
                        'PrisonerTransfer.final_save_date'    => "'$cdate'",
                        'PrisonerTransfer.final_save_by'    => $login_user_id
                    );
                }
                if($usertype_id == 4)
                {
                    $fields += array(
                        'PrisonerTransfer.out_reviewed_date'    => "'$cdate'",
                        'PrisonerTransfer.out_reviewed_by'    => $login_user_id
                    );
                }
                if($usertype_id == 3)
                {
                    $fields += array(
                        'PrisonerTransfer.out_approved_date'    => "'$cdate'",
                        'PrisonerTransfer.out_approved_by'    => $login_user_id
                    );
                }
            }
            
            $conds = array(
                'PrisonerTransfer.id'    => $uuid,
            );
            
            if($this->PrisonerTransfer->updateAll($fields, $conds)){

                //update prisoner transfer info 
                if($status == 'Rejected')
                {
                    $pfields = array(
                        'Prisoner.transfer_status' => "'Deleted'"
                        
                    );
                    $pconds = array(
                        'Prisoner.transfer_id'  =>  $transfer_id
                    );
                    $this->Prisoner->updateAll($pfields, $pconds);
                }
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }
     function setTransferInStatus()
     {
        $this->autoRender = false;
        $login_user_id = $this->Session->read('Auth.User.id');
        $usertype_id = $this->Session->read('Auth.User.usertype_id');
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $status = $this->data['status'];
            $fields = array(
                'PrisonerTransfer.instatus'    => "'$status'",
            );
            $cdate = date('Y-m-d');

            if($status == 'Rejected')
            {
                $fields += array(
                    'PrisonerTransfer.rejected_date'    => "'$cdate'",
                    'PrisonerTransfer.rejected_by'    => $login_user_id
                );
            }
            else
            {
                if($usertype_id == 5)
                {
                    $fields += array(
                        'PrisonerTransfer.rcv_date'  => "'$cdate'",
                        'PrisonerTransfer.rcv_by'    => $login_user_id,
                        'PrisonerTransfer.status'    => "'Recieved'"
                    );
                }
                if($usertype_id == 4)
                {
                    $fields += array(
                        'PrisonerTransfer.in_reviewed_date'    => "'$cdate'",
                        'PrisonerTransfer.in_reviewed_by'    => $login_user_id
                    );
                }
                if($usertype_id == 3)
                {
                    $fields += array(
                        'PrisonerTransfer.in_approved_date'    => "'$cdate'",
                        'PrisonerTransfer.in_approved_by'      => $login_user_id
                    );
                }
            }
            //echo '<pre>'; print_r($fields); exit;
            $conds = array(
                'PrisonerTransfer.id'    => $uuid,
            );
            
            if($this->PrisonerTransfer->updateAll($fields, $conds))
            {
                //Admit prisoner in station if approved by principal offocer -- START --
                if($status == 'Approved')
                {
                    $this->admitTransferPrisoner($uuid);
                }
                if($status == 'Recieved' || $status == 'Rejected')
                {
                    //get transfer prisoner id
                    $prisonTransferData = $this->PrisonerTransfer->findById($uuid);
                    if(isset($prisonTransferData['PrisonerTransfer']['prisoner_id']) && $prisonTransferData['PrisonerTransfer']['prisoner_id'] != '')
                    {
                        $pfields = array(
                            'Prisoner.transfer_status' => $status,
                            'Prisoner.transfer_id'     =>  $uuid
                        );
                        $pconds = array(
                            'Prisoner.id'     => $prisonTransferData['PrisonerTransfer']['prisoner_id']
                        );
                        $this->Prisoner->updateAll($pfields, $pconds);
                    }
                }
                //Admit prisoner in station if approved by principal offocer -- END --
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
     }     
     //Admit prisoner from station to new station -- START --
     function admitTransferPrisoner($transfer_id)
     {
        $this->autoRender = false; 
        $prison_id = $this->Auth->user('prison_id'); 
        //get transfer prisoner no
        $transferPrisonerData = $this->PrisonerTransfer->findById($transfer_id);
        //echo '<pre>'; print_r($transferPrisonerData); exit;
        $from_prisoner_prisoner_no = $transferPrisonerData['Prisoner']['prisoner_no'];
        $from_prisoner_id = $transferPrisonerData['Prisoner']['id'];
        $prisonName = $transferPrisonerData['Prison']['name'];
        $login_user_id = $transferPrisonerData['PrisonerTransfer']['rcv_by'];
        //get ftom prisoner transfer details
        $from_prisonerdata = $this->Prisoner->find('first', array(
            'recursive'     => -1,
            'conditions'    => array(
                'Prisoner.prisoner_no' => $from_prisoner_prisoner_no,
            ),
        ));
        //create uuid
        $uuid = $this->Prisoner->query("select uuid() as code");
        $uuid = $uuid[0][0]['code'];
        $from_prisonerdata['Prisoner']['uuid'] = $uuid;

        //set to prison station id
        $from_prisonerdata['Prisoner']['prison_id'] = $prison_id;

        //set all recieve, verify and approve details 
        $from_prisonerdata['Prisoner']['is_final_save'] = 1;
        $from_prisonerdata['Prisoner']['final_save_date'] = $transferPrisonerData['PrisonerTransfer']['rcv_date'];
        $from_prisonerdata['Prisoner']['final_save_by'] = $transferPrisonerData['PrisonerTransfer']['rcv_by'];

        $from_prisonerdata['Prisoner']['is_verify'] = 1;
        $from_prisonerdata['Prisoner']['verify_date'] = $transferPrisonerData['PrisonerTransfer']['review_date'];
        $from_prisonerdata['Prisoner']['verify_by'] = $transferPrisonerData['PrisonerTransfer']['in_verified_by'];

        $from_prisonerdata['Prisoner']['is_approve'] = 1;
        $from_prisonerdata['Prisoner']['final_save_date'] = $transferPrisonerData['PrisonerTransfer']['approve_date'];
        $from_prisonerdata['Prisoner']['final_save_by'] = $transferPrisonerData['PrisonerTransfer']['in_approved_by'];

        //set transfer id 
        $from_prisonerdata['Prisoner']['transfer_id'] = $transferPrisonerData['PrisonerTransfer']['id'];

        $from_prisonerdata['Prisoner']['id'] = '';
        $from_prisonerdata['Prisoner']['prisoner_no'] = '';
        $from_prisonerdata['Prisoner']['created'] = '';
        $from_prisonerdata['Prisoner']['modified'] = '';
        //echo '<pre>'; print_r($from_prisonerdata); exit;
        //unset photo validation 
        unset($this->Prisoner->validate['photo']);
        //save prisoner 
        if($this->Prisoner->save($from_prisonerdata)){
            //create prisoner no
            $prisoner_id    = $this->Prisoner->id;
            $prisoner_no    = strtoupper(substr($prisonName, 0, 3)).'/'.str_pad($prisoner_id,6,'0',STR_PAD_LEFT) .'/'.date('Y');
            $fields = array(
                'Prisoner.prisoner_no'  => "'$prisoner_no'",
            );
            $conds = array(
                'Prisoner.id'       => $prisoner_id,
            );
            //echo '<pre>'; print_r($from_prisonerdata); echo $prisoner_no; exit;
            //update prisoner no 
            if($this->Prisoner->updateAll($fields, $conds)){
                //get prisoner admission data
                $admissionData  = $this->PrisonerAdmissionDetail->find('first', array(
                    'recursive'     => -1,
                    'conditions'    => array(
                        'PrisonerAdmissionDetail.prisoner_id'  => $from_prisoner_id
                    )
                ));
                //save prisoner admission data unset($admissionData['PrisonerAdmissionDetail']['id']);
                $admissionData['PrisonerAdmissionDetail']['puuid'] = '';
                $admissionData['PrisonerAdmissionDetail']['login_user_id'] = $login_user_id;
                $admissionData['PrisonerAdmissionDetail']['prisoner_no'] = $prisoner_no;
                $admissionData['PrisonerAdmissionDetail']['prisoner_id'] = $prisoner_id;

                $ad_uuid = $this->PrisonerAdmissionDetail->query("select uuid() as code");
                $ad_uuid = $ad_uuid[0][0]['code'];
                $admissionData['PrisonerAdmissionDetail']['uuid'] = $ad_uuid;

                $this->PrisonerAdmissionDetail->save($admissionData);

                //get existing prisoner sentence details 
                $sentenceData      = $this->PrisonerSentenceDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerSentenceDetail.prisoner_id'      => $from_prisoner_id,
                        'PrisonerSentenceDetail.is_trash'    => 0
                    )
                ));
                if(count($sentenceData) > 0)
                {
                    foreach($sentenceData as $senidkey=>$senidval)
                    {
                        $senData = '';
                        $senData['PrisonerSentenceDetail'] = $senidval['PrisonerSentenceDetail'];
                        $senData['PrisonerSentenceDetail']['login_user_id'] = $login_user_id;
                        unset($senData['PrisonerSentenceDetail']['id']);
                        $senData['PrisonerSentenceDetail']['puuid'] = '';
                        $senData['PrisonerSentenceDetail']['prisoner_no'] = $prisoner_no;
                        $senData['PrisonerSentenceDetail']['prisoner_id'] = $prisoner_id;

                        $sen_uuid = $this->PrisonerSentenceDetail->query("select uuid() as code");
                        $sen_uuid = $sen_uuid[0][0]['code'];
                        $senData['PrisonerSentenceDetail']['uuid'] = $sen_uuid;

                        $this->PrisonerSentenceDetail->save($senData);
                    }
                }

                //get existing prisoner id proof details 
                $idproofData      = $this->PrisonerIdDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerIdDetail.prisoner_id'      => $from_prisoner_id,
                        'PrisonerIdDetail.is_trash'    => 0
                    )
                ));
                if(count($idproofData) > 0)
                {
                    foreach($idproofData as $idkey=>$idval)
                    {
                        $pidData = '';
                        $pidData['PrisonerIdDetail'] = $idval['PrisonerIdDetail'];
                        $pidData['PrisonerIdDetail']['login_user_id'] = $login_user_id;
                        unset($pidData['PrisonerIdDetail']['id']);
                        $pidData['PrisonerIdDetail']['puuid'] = '';
                        $pidData['PrisonerIdDetail']['prisoner_no'] = $prisoner_no;
                        $pidData['PrisonerIdDetail']['prisoner_id'] = $prisoner_id;

                        $idp_uuid = $this->PrisonerIdDetail->query("select uuid() as code");
                        $idp_uuid = $idp_uuid[0][0]['code'];
                        $pidData['PrisonerIdDetail']['uuid'] = $idp_uuid;

                        $this->PrisonerIdDetail->save($pidData);
                    }
                }
                //get existing prisoner kin details 
                $kinDataList      = $this->PrisonerKinDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerKinDetail.prisoner_id'      => $from_prisoner_id,
                        'PrisonerKinDetail.is_trash'    => 0
                    )
                ));
                if(count($kinDataList) > 0)
                {
                    foreach($kinDataList as $kinDatakey=>$kinDataval)
                    {
                        $kinData = '';
                        $kinData['PrisonerKinDetail'] = $kinDataval['PrisonerKinDetail'];
                        $kinData['PrisonerKinDetail']['login_user_id'] = $login_user_id;
                        unset($kinData['PrisonerKinDetail']['id']);
                        $kinData['PrisonerKinDetail']['puuid'] = '';
                        $kinData['PrisonerKinDetail']['prisoner_id'] = $prisoner_id;

                        $kin_uuid = $this->PrisonerKinDetail->query("select uuid() as code");
                        $kin_uuid = $kin_uuid[0][0]['code'];
                        $kinData['PrisonerKinDetail']['uuid'] = $kin_uuid;

                        $this->PrisonerKinDetail->save($kinData);
                    }
                }
                //get existing prisoner child details 
                $childDataList      = $this->PrisonerChildDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerChildDetail.prisoner_id'      => $from_prisoner_id,
                        'PrisonerChildDetail.is_trash'    => 0
                    )
                ));
                if(count($childDataList) > 0)
                {
                    foreach($childDataList as $childDatakey=>$childDataval)
                    {
                        $childData = '';
                        $childData['PrisonerChildDetail'] = $childDataval['PrisonerChildDetail'];
                        $childData['PrisonerChildDetail']['login_user_id'] = $login_user_id;
                        unset($childData['PrisonerChildDetail']['id']);
                        $childData['PrisonerChildDetail']['puuid'] = '';
                        $childData['PrisonerChildDetail']['prisoner_no'] = $prisoner_no;
                        $childData['PrisonerChildDetail']['prisoner_id'] = $prisoner_id;

                        $child_uuid = $this->PrisonerChildDetail->query("select uuid() as code");
                        $child_uuid = $child_uuid[0][0]['code'];
                        $childData['PrisonerChildDetail']['uuid'] = $child_uuid;

                        $this->PrisonerChildDetail->save($childData);
                    }
                }
                //get existing prisoner special needs
                $snDataList      = $this->PrisonerSpecialNeed->find('all', array(
                    'conditions'    => array(
                        'PrisonerSpecialNeed.prisoner_id'   => $from_prisoner_id,
                        'PrisonerSpecialNeed.is_trash'    => 0
                    )
                ));
                if(count($snDataList) > 0)
                {
                    foreach($snDataList as $snDatakey=>$snDataval)
                    {
                        $snData = '';
                        $snData['PrisonerSpecialNeed'] = $snDataval['PrisonerSpecialNeed'];
                        $snData['PrisonerSpecialNeed']['login_user_id'] = $login_user_id;
                        unset($snData['PrisonerSpecialNeed']['id']);
                        $snData['PrisonerSpecialNeed']['puuid'] = '';
                        $snData['PrisonerSpecialNeed']['prisoner_no'] = $prisoner_no;
                        $snData['PrisonerSpecialNeed']['prisoner_id'] = $prisoner_id;

                        $sn_uuid = $this->PrisonerSpecialNeed->query("select uuid() as code");
                        $sn_uuid = $sn_uuid[0][0]['code'];
                        $snData['PrisonerSpecialNeed']['uuid'] = $sn_uuid;

                        $this->PrisonerSpecialNeed->save($snData);
                    }
                }
                //get existing prisoner offences
                $offenceDataList      = $this->PrisonerOffenceDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerOffenceDetail.prisoner_id'   => $from_prisoner_id,
                        'PrisonerOffenceDetail.is_trash'    => 0
                    )
                ));
                if(count($offenceDataList) > 0)
                {
                    foreach($offenceDataList as $offenceDatakey=>$offenceDataval)
                    {
                        $offenceData = '';
                        $offenceData['PrisonerOffenceDetail'] = $offenceDataval['PrisonerOffenceDetail'];
                        $offenceData['PrisonerOffenceDetail']['login_user_id'] = $login_user_id;
                        unset($offenceData['PrisonerOffenceDetail']['id']);
                        $offenceData['PrisonerOffenceDetail']['puuid'] = '';
                        $offenceData['PrisonerOffenceDetail']['prisoner_no'] = $prisoner_no;
                        $offenceData['PrisonerOffenceDetail']['prisoner_id'] = $prisoner_id;

                        $offence_uuid = $this->PrisonerOffenceDetail->query("select uuid() as code");
                        $offence_uuid = $offence_uuid[0][0]['code'];
                        $offenceData['PrisonerOffenceDetail']['uuid'] = $offence_uuid;

                        $this->PrisonerOffenceDetail->save($offenceData);
                    }
                }
                //get existing prisoner offence counts
                $offenceCountDataList      = $this->PrisonerOffenceCount->find('all', array(
                    'conditions'    => array(
                        'PrisonerOffenceCount.prisoner_id'   => $from_prisoner_id,
                        'PrisonerOffenceCount.is_trash'    => 0
                    )
                ));
                if(count($offenceCountDataList) > 0)
                {
                    foreach($offenceCountDataList as $offenceCountDatakey=>$offenceCountDataval)
                    {
                        $offenceCountData = '';
                        $offenceCountData['PrisonerOffenceCount'] = $offenceCountDataval['PrisonerOffenceCount'];
                        $offenceCountData['PrisonerOffenceCount']['login_user_id'] = $login_user_id;
                        unset($offenceCountData['PrisonerOffenceCount']['id']);
                        $offenceCountData['PrisonerOffenceCount']['puuid'] = '';
                        $offenceCountData['PrisonerOffenceCount']['prisoner_no'] = $prisoner_no;
                        $offenceCountData['PrisonerOffenceCount']['prisoner_id'] = $prisoner_id;

                        $offenceCount_uuid = $this->PrisonerOffenceCount->query("select uuid() as code");
                        $offenceCount_uuid = $offenceCount_uuid[0][0]['code'];
                        $offenceCountData['PrisonerOffenceCount']['uuid'] = $offenceCount_uuid;

                        $this->PrisonerOffenceCount->save($offenceCountData);
                    }
                }
                //get existing prisoner recapture details
                $recaptureDataList      = $this->PrisonerRecaptureDetail->find('all', array(
                    'conditions'    => array(
                        'PrisonerRecaptureDetail.prisoner_id'   => $from_prisoner_id,
                        'PrisonerRecaptureDetail.is_trash'    => 0
                    )
                ));
                if(count($recaptureDataList) > 0)
                {
                    foreach($recaptureDataList as $recaptureDatakey=>$recaptureDataval)
                    {
                        $recaptureData = '';
                        $recaptureData['PrisonerRecaptureDetail'] = $recaptureData['PrisonerRecaptureDetail'];
                        $recaptureData['PrisonerRecaptureDetail']['login_user_id'] = $login_user_id;
                        unset($recaptureData['PrisonerRecaptureDetail']['id']);
                        $recaptureData['PrisonerRecaptureDetail']['puuid'] = '';
                        $recaptureData['PrisonerRecaptureDetail']['prisoner_no'] = $prisoner_no;
                        $recaptureData['PrisonerRecaptureDetail']['prisoner_id'] = $prisoner_id;

                        $recapture_uuid = $this->PrisonerRecaptureDetail->query("select uuid() as code");
                        $recapture_uuid = $recapture_uuid[0][0]['code'];
                        $recaptureData['PrisonerRecaptureDetail']['uuid'] = $recapture_uuid;

                        $this->PrisonerRecaptureDetail->save($recaptureData);
                    }
                }
                //get existing prisoner medical checkup details
                $checkupDataList      = $this->MedicalCheckupRecord->find('all', array(
                    'conditions'    => array(
                        'MedicalCheckupRecord.prisoner_id'   => $from_prisoner_id,
                        'MedicalCheckupRecord.is_trash'    => 0
                    )
                ));
                if(count($checkupDataList) > 0)
                {
                    foreach($checkupDataList as $checkupDatakey=>$checkupDataval)
                    {
                        $checkupData = '';
                        $checkupData['MedicalCheckupRecord'] = $checkupData['MedicalCheckupRecord'];
                        $checkupData['MedicalCheckupRecord']['login_user_id'] = $login_user_id;
                        unset($checkupData['MedicalCheckupRecord']['id']);
                        $checkupData['MedicalCheckupRecord']['puuid'] = '';
                        $checkupData['MedicalCheckupRecord']['prisoner_id'] = $prisoner_id;

                        $checkup_uuid = $this->MedicalCheckupRecord->query("select uuid() as code");
                        $checkup_uuid = $checkup_uuid[0][0]['code'];
                        $checkupData['MedicalCheckupRecord']['uuid'] = $checkup_uuid;

                        $this->MedicalCheckupRecord->save($checkupData);
                    }
                }
                //get existing prisoner medical sick details
                $sickDataList      = $this->MedicalSickRecord->find('all', array(
                    'conditions'    => array(
                        'MedicalSickRecord.prisoner_id'   => $from_prisoner_id,
                        'MedicalSickRecord.is_trash'    => 0
                    )
                ));
                if(count($sickDataList) > 0)
                {
                    foreach($sickDataList as $sickDatakey=>$sickDataval)
                    {
                        $sickData = '';
                        $sickData['MedicalSickRecord'] = $sickData['MedicalSickRecord'];
                        $sickData['MedicalSickRecord']['login_user_id'] = $login_user_id;
                        unset($sickData['MedicalSickRecord']['id']);
                        $sickData['MedicalSickRecord']['puuid'] = '';
                        $sickData['MedicalSickRecord']['prisoner_id'] = $prisoner_id;

                        $sick_uuid = $this->MedicalSickRecord->query("select uuid() as code");
                        $sick_uuid = $sick_uuid[0][0]['code'];
                        $sickData['MedicalSickRecord']['uuid'] = $sick_uuid;

                        $this->MedicalSickRecord->save($sickData);
                    }
                }
                //get existing prisoner medical serious ill details
                $seriousIllDataList      = $this->MedicalSeriousIllRecord->find('all', array(
                    'conditions'    => array(
                        'MedicalSeriousIllRecord.prisoner_id'   => $from_prisoner_id,
                        'MedicalSeriousIllRecord.is_trash'    => 0
                    )
                ));
                if(count($seriousIllDataList) > 0)
                {
                    foreach($seriousIllDataList as $seriousIllDatakey=>$seriousIllDataval)
                    {
                        $seriousIllData = '';
                        $seriousIllData['MedicalSeriousIllRecord'] = $seriousIllData['MedicalSeriousIllRecord'];
                        $seriousIllData['MedicalSeriousIllRecord']['login_user_id'] = $login_user_id;
                        unset($seriousIllData['MedicalSeriousIllRecord']['id']);
                        $seriousIllData['MedicalSeriousIllRecord']['puuid'] = '';
                        $seriousIllData['MedicalSeriousIllRecord']['prisoner_id'] = $prisoner_id;

                        $seriousIll_uuid = $this->MedicalSeriousIllRecord->query("select uuid() as code");
                        $seriousIll_uuid = $seriousIll_uuid[0][0]['code'];
                        $seriousIllData['MedicalSeriousIllRecord']['uuid'] = $seriousIll_uuid;

                        $this->MedicalSeriousIllRecord->save($seriousIllData);
                    }
                }
                //get existing prisoner medical death details
                $deathDataList      = $this->MedicalDeathRecord->find('all', array(
                    'conditions'    => array(
                        'MedicalDeathRecord.prisoner_id'   => $from_prisoner_id,
                        'MedicalDeathRecord.is_trash'    => 0
                    )
                ));
                if(count($deathDataList) > 0)
                {
                    foreach($deathDataList as $deathDatakey=>$deathDataval)
                    {
                        $deathData = '';
                        $deathData['MedicalDeathRecord'] = $deathData['MedicalDeathRecord'];
                        $deathData['MedicalDeathRecord']['login_user_id'] = $login_user_id;
                        unset($deathData['MedicalDeathRecord']['id']);
                        $deathData['MedicalDeathRecord']['puuid'] = '';
                        $deathData['MedicalDeathRecord']['prisoner_id'] = $prisoner_id;

                        $death_uuid = $this->MedicalDeathRecord->query("select uuid() as code");
                        $death_uuid = $death_uuid[0][0]['code'];
                        $deathData['MedicalDeathRecord']['uuid'] = $death_uuid;

                        $this->MedicalDeathRecord->save($deathData);
                    }
                }
                //get existing prisoner stage promotion details
                $stagePromotionDataList      = $this->StagePromotion->find('all', array(
                    'conditions'    => array(
                        'StagePromotion.prisoner_id'   => $from_prisoner_id,
                        'StagePromotion.is_trash'    => 0
                    )
                ));
                if(count($stagePromotionDataList) > 0)
                {
                    foreach($stagePromotionDataList as $stagePromotionDatakey=>$stagePromotionDataval)
                    {
                        $stagePromotionData = '';
                        $stagePromotionData['StagePromotion'] = $stagePromotionData['StagePromotion'];
                        $stagePromotionData['StagePromotion']['login_user_id'] = $login_user_id;
                        unset($stagePromotionData['StagePromotion']['id']);
                        $stagePromotionData['StagePromotion']['puuid'] = '';
                        $stagePromotionData['StagePromotion']['prisoner_id'] = $prisoner_id;

                        $stagePromotion_uuid = $this->StagePromotion->query("select uuid() as code");
                        $stagePromotion_uuid = $stagePromotion_uuid[0][0]['code'];
                        $stagePromotionData['StagePromotion']['uuid'] = $stagePromotion_uuid;

                        $this->StagePromotion->save($stagePromotionData);
                    }
                }
                //get existing prisoner stage demotion details
                $stageDemotionDataList      = $this->StageDemotion->find('all', array(
                    'conditions'    => array(
                        'StageDemotion.prisoner_id'   => $from_prisoner_id,
                        'StageDemotion.is_trash'    => 0
                    )
                ));
                if(count($stageDemotionDataList) > 0)
                {
                    foreach($stageDemotionDataList as $stageDemotionDatakey=>$stageDemotionDataval)
                    {
                        $stageDemotionData = '';
                        $stageDemotionData['StageDemotion'] = $stageDemotionData['StageDemotion'];
                        $stageDemotionData['StageDemotion']['login_user_id'] = $login_user_id;
                        unset($stageDemotionData['StageDemotion']['id']);
                        $stageDemotionData['StageDemotion']['puuid'] = '';
                        $stageDemotionData['StageDemotion']['prisoner_id'] = $prisoner_id;

                        $stageDemotion_uuid = $this->StageDemotion->query("select uuid() as code");
                        $stageDemotion_uuid = $stageDemotion_uuid[0][0]['code'];
                        $stageDemotionData['StageDemotion']['uuid'] = $stageDemotion_uuid;

                        $this->StageDemotion->save($stageDemotionData);
                    }
                }
                //get existing prisoner stage Reinstatement details
                $stageReinstatementDataList      = $this->StageReinstatement->find('all', array(
                    'conditions'    => array(
                        'StageReinstatement.prisoner_id'   => $from_prisoner_id,
                        'StageReinstatement.is_trash'    => 0
                    )
                ));
                if(count($stageReinstatementDataList) > 0)
                {
                    foreach($stageReinstatementDataList as $stageReinstatementDatakey=>$stageReinstatementDataval)
                    {
                        $stageReinstatementData = '';
                        $stageReinstatementData['StageReinstatement'] = $stageReinstatementData['StageReinstatement'];
                        $stageReinstatementData['StageReinstatement']['login_user_id'] = $login_user_id;
                        unset($stageReinstatementData['StageReinstatement']['id']);
                        $stageReinstatementData['StageReinstatement']['puuid'] = '';
                        $stageReinstatementData['StageReinstatement']['prisoner_id'] = $prisoner_id;

                        $stageReinstatement_uuid = $this->StageReinstatement->query("select uuid() as code");
                        $stageReinstatement_uuid = $stageReinstatement_uuid[0][0]['code'];
                        $stageReinstatementData['StageReinstatement']['uuid'] = $stageReinstatement_uuid;

                        $this->StageReinstatement->save($stageReinstatementData);
                    }
                }
                //get existing prisoner in prison offence details
                $inPrisonOffenceDataList      = $this->InPrisonOffenceCapture->find('all', array(
                    'conditions'    => array(
                        'InPrisonOffenceCapture.prisoner_id'   => $from_prisoner_id,
                        'InPrisonOffenceCapture.is_trash'    => 0
                    )
                ));
                if(count($inPrisonOffenceDataList) > 0)
                {
                    foreach($inPrisonOffenceDataList as $inPrisonOffenceDatakey=>$inPrisonOffenceDataval)
                    {
                        $inPrisonOffenceData = '';
                        $inPrisonOffenceData['InPrisonOffenceCapture'] = $inPrisonOffenceData['InPrisonOffenceCapture'];
                        $inPrisonOffenceData['InPrisonOffenceCapture']['login_user_id'] = $login_user_id;
                        unset($inPrisonOffenceData['InPrisonOffenceCapture']['id']);
                        $inPrisonOffenceData['InPrisonOffenceCapture']['puuid'] = '';
                        $inPrisonOffenceData['InPrisonOffenceCapture']['prisoner_id'] = $prisoner_id;

                        $inPrisonOffence_uuid = $this->InPrisonOffenceCapture->query("select uuid() as code");
                        $inPrisonOffence_uuid = $inPrisonOffence_uuid[0][0]['code'];
                        $inPrisonOffenceData['InPrisonOffenceCapture']['uuid'] = $inPrisonOffence_uuid;

                        $this->InPrisonOffenceCapture->save($inPrisonOffenceData);
                    }
                }
                //get existing prisoner in prison punishment details
                $inPrisonPunishmentDataList      = $this->InPrisonPunishment->find('all', array(
                    'conditions'    => array(
                        'InPrisonPunishment.prisoner_id'   => $from_prisoner_id,
                        'InPrisonPunishment.is_trash'    => 0
                    )
                ));
                if(count($inPrisonPunishmentDataList) > 0)
                {
                    foreach($inPrisonPunishmentDataList as $inPrisonPunishmentDatakey=>$inPrisonPunishmentDataval)
                    {
                        $inPrisonPunishmentData = '';
                        $inPrisonPunishmentData['InPrisonPunishment'] = $inPrisonPunishmentData['InPrisonPunishment'];
                        $inPrisonPunishmentData['InPrisonPunishment']['login_user_id'] = $login_user_id;
                        unset($inPrisonPunishmentData['InPrisonPunishment']['id']);
                        $inPrisonPunishmentData['InPrisonPunishment']['puuid'] = '';
                        $inPrisonPunishmentData['InPrisonPunishment']['prisoner_id'] = $prisoner_id;

                        $inPrisonPunishment_uuid = $this->InPrisonPunishment->query("select uuid() as code");
                        $inPrisonPunishment_uuid = $inPrisonPunishment_uuid[0][0]['code'];
                        $inPrisonPunishmentData['InPrisonPunishment']['uuid'] = $inPrisonPunishment_uuid;

                        $this->InPrisonPunishment->save($inPrisonPunishmentData);
                    }
                }
                //get existing prisoner's earning and forward as property to next prison 
                //get prisoner's total balance till current date 
                $balance = $funcall->getPrisonerBalance($prisoner_id);
                $property['Property']['prisoner_id'] = $prisoner_id; 
                $property['Property']['source'] = 'On transfer';

                $property_uuid = $this->Property->query("select uuid() as code");
                $property_uuid = $property_uuid[0][0]['code'];
                $propertyData['InPrisonPunishment']['uuid'] = $property_uuid;
                $propertyData['InPrisonPunishment']['property_date'] = date('Y-m-d');

                //get existing prisoner property records and forward to next prison 
                $propertyDataList      = $this->Property->find('all', array(
                    'conditions'    => array(
                        'Property.prisoner_id'   => $from_prisoner_id,
                        'Property.is_trash'    => 0
                    )
                ));
                if(count($propertyDataList) > 0)
                {
                    foreach($propertyDataList as $propertyDatakey=>$propertyDataval)
                    {
                        $propertyData = '';
                        $propertyData['Property'] = $propertyData['Property'];
                        $propertyData['Property']['login_user_id'] = $login_user_id;
                        unset($propertyData['Property']['id']);
                        $propertyData['Property']['puuid'] = '';
                        $propertyData['Property']['prisoner_id'] = $prisoner_id;

                        $property_uuid = $this->Property->query("select uuid() as code");
                        $property_uuid = $property_uuid[0][0]['code'];
                        $propertyData['Property']['uuid'] = $property_uuid;

                        $this->Property->save($propertyData);
                    }
                }
                // -- END --
            }
        }
        else 
        {
            debug($this->Prisoner->validationErrors);
        }
        //echo '<pre>'; print_r($from_prisonerdata); exit;
     }
     //Admit prisoner from station to new station -- END --
     //Module: Prisoner Transfer -- END --
 }