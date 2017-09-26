<?php
App::uses('AppController', 'Controller');
class InPrisonOffenceCaptureController   extends AppController {
    public $layout='table';
    public $uses=array('InPrisonOffenceCapture','InternalOffence','Prisoner','InPrisonPunishment','InternalPunishment');

    public function index($uuid){
       
         if($uuid){
            $prisonList = $this->Prisoner->find('first', array(
                'recursive'     => -1,
                'conditions'    => array(
                    'Prisoner.uuid'     => $uuid,
                ),
            ));
         if(isset($prisonList['Prisoner']['id']) && (int)$prisonList['Prisoner']['id'] != 0){
                $prisoner_id = $prisonList['Prisoner']['id'];   
                
        /*
        *code add the InPrisonOffenceCapture 
        */
          if(isset($this->data['InPrisonOffenceCapture']) && is_array($this->data['InPrisonOffenceCapture']) && $this->data['InPrisonOffenceCapture']!='')
          {
            //debug($this->data['InPrisonOffenceCapture']['uuid']);
             if(isset($this->data['InPrisonOffenceCapture']['uuid']) && $this->data['InPrisonOffenceCapture']['uuid']=='')
             {
               
                $uuidArr=$this->InPrisonOffenceCapture->query("select uuid() as code");
                $this->request->data['InPrisonOffenceCapture']['uuid']=$uuidArr[0][0]['code'];
               
             }  
             if(isset($this->data['InPrisonOffenceCapture']['offence_date']) && $this->data['InPrisonOffenceCapture']['offence_date']!="" )
             {
                $this->request->data['InPrisonOffenceCapture']['offence_date']=date('Y-m-d',strtotime($this->data['InPrisonOffenceCapture']['offence_date']));
             }
             
             if($this->InPrisonOffenceCapture->save($this->data))
             {
                $this->Session->write('message_type','success');
                $this->Session->write('message','Saved successfully');
                $this->redirect('/inPrisonOffenceCapture/index/'.$uuid.'#offences');
                
                
             } 
             else{
                $this->Session->write('message_type','error');
                $this->Session->write('message','saving failed');

             }
          }
            /*
             *Code for edit the Earning Rates
             */
            if(isset($this->data['InPrisonOffenceCaptureEdit']['id']) && (int)$this->data['InPrisonOffenceCaptureEdit']['id'] != 0){
                if($this->InPrisonOffenceCapture->exists($this->data['InPrisonOffenceCaptureEdit']['id'])){
                    $this->data = $this->InPrisonOffenceCapture->findById($this->data['InPrisonOffenceCaptureEdit']['id']);
                }
            }
               
                if(isset($this->data['InPrisonPunishment']) && is_array($this->data['InPrisonPunishment']) && $this->data['InPrisonPunishment']!=''){
                //debug($this->data['InPrisonOffenceCapture']['uuid']);
                 if(isset($this->data['InPrisonPunishment']['uuid']) && $this->data['InPrisonPunishment']['uuid']=='')
                 {
                   
                    $uuidArr=$this->InPrisonPunishment->query("select uuid() as code");
                    $this->request->data['InPrisonPunishment']['uuid']=$uuidArr[0][0]['code'];
                   
                 }  
                 if(isset($this->data['InPrisonPunishment']['punishment_date']) && $this->data['InPrisonPunishment']['punishment_date']!="" )
                 {
                    $this->request->data['InPrisonPunishment']['punishment_date']=date('Y-m-d',strtotime($this->data['InPrisonPunishment']['punishment_date']));
                 }
                 if(isset($this->data['InPrisonPunishment']['punishment_start_date']) && $this->data['InPrisonPunishment']['punishment_start_date']!="" )
                 {
                    $this->request->data['InPrisonPunishment']['punishment_start_date']=date('Y-m-d',strtotime($this->data['InPrisonPunishment']['punishment_start_date']));
                 }
                 if(isset($this->data['InPrisonPunishment']['punishment_end_date']) && $this->data['InPrisonPunishment']['punishment_end_date']!="" )
                 {
                    $this->request->data['InPrisonPunishment']['punishment_end_date']=date('Y-m-d',strtotime($this->data['InPrisonPunishment']['punishment_end_date']));
                 }
                 if($this->InPrisonPunishment->save($this->data))
                 {
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved successfully');
                    $this->redirect('/inPrisonOffenceCapture/index/'.$uuid.'#punishments');
                    
                    
                 } 
                 else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','saving failed');

                 }
              }
                /*
                 *Code for edit the Earning Rates
                 */
                if(isset($this->data['InPrisonPunishmentEdit']['id']) && (int)$this->data['InPrisonPunishmentEdit']['id'] != 0){
                    if($this->InPrisonPunishment->exists($this->data['InPrisonPunishmentEdit']['id'])){
                        $this->data = $this->InPrisonPunishment->findById($this->data['InPrisonPunishmentEdit']['id']);
                    }
                }
            $offenceList=$this->InternalOffence->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'InternalOffence.id',
                        'InternalOffence.name',
                    ),
                    'conditions'    => array(
                        'InternalOffence.is_enable'    => 1,
                        'InternalOffence.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'InternalOffence.name'
                    )
                )); 
            //For punishments 
            $offencesList=$this->InPrisonOffenceCapture->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'InPrisonOffenceCapture.id',
                        'InternalOffence.name',
                    ),
                     "joins" => array(
                        array(
                            "table" => "internal_offences",
                            "alias" => "InternalOffence",
                            "type" => "LEFT",
                            "conditions" => array(
                            "InPrisonOffenceCapture.internal_offence_id = InternalOffence.id"
                            )
                        )),
                    'conditions'    => array(
                       
                        'InPrisonOffenceCapture.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'InternalOffence.name'
                    )
                ));
            $punishmentsList=$this->InternalPunishment->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'InternalPunishment.id',
                        'InternalPunishment.name',
                    ),
                    'conditions'    => array(
                        'InternalPunishment.is_enable'    => 1,
                        'InternalPunishment.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'InternalPunishment.name'
                    )
                ));  
                   
           $this->set(array(
                    'uuid'              => $uuid,
                    'prisoner_id'       => $prisoner_id,
                    'offenceList'       => $offenceList,
                    'punishmentsList'   => $punishmentsList,
                    'offencesList'      => $offencesList   
                    
                ));
         }
      
      else{
                return $this->redirect(array('controller'=>'prisoners', 'action' => 'index')); 
           
         }
        } else{
            return $this->redirect(array('controller'=>'prisoners', 'action' => 'index')); 
        }
     
    }
    public function indexAjax()
     {
       $this->layout = 'ajax';
       if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
            $prisoner_id  = $this->params['named']['prisoner_id'];
            $uuid           = $this->params['named']['uuid'];
           
            $condition      = array(
                'InPrisonOffenceCapture.prisoner_id'     => $prisoner_id,
                'InPrisonOffenceCapture.is_trash'        => 0,
            );

            if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
                if($this->params['named']['reqType']=='XLS'){
                    $this->layout='export_xls';
                    $this->set('file_type','xls');
                    $this->set('file_name','offfences_report_'.date('d_m_Y').'.xls');
                }else if($this->params['named']['reqType']=='DOC'){
                    $this->layout='export_xls';
                    $this->set('file_type','doc');
                    $this->set('file_name','offfences_report_'.date('d_m_Y').'.doc');
                }
                $this->set('is_excel','Y');         
                $limit = array('limit' => 2000,'maxLimit'   => 2000);
            }else{
                $limit = array('limit'  => 20);
            }           
            $this->paginate = array(
                'conditions'    => $condition,
                'order'         => array(
                    'InPrisonOffenceCapture.modified'    => 'DESC',
                ),
            )+$limit;
            $datas = $this->paginate('InPrisonOffenceCapture');
            
             
            $this->set(array(
                'datas'         => $datas,
                'prisoner_id'   => $prisoner_id,
                'uuid'          => $uuid,
            ));
        }
     }
     public function deleteOffences(){
        $this->autoRender = false;

        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'InPrisonOffenceCapture.is_trash'    => 1,
            );
            $conds = array(
                'InPrisonOffenceCapture.uuid'    => $uuid,
            );
            if($this->InPrisonOffenceCapture->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    public function showPunishmentsRecords()
     {
        $this->layout = 'ajax';

        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
            $prisoner_id  = $this->params['named']['prisoner_id'];
            $uuid           = $this->params['named']['uuid'];   
           
            $condition      = array(
                'InPrisonPunishment.prisoner_id'     => $prisoner_id,
                'InPrisonPunishment.is_trash'        => 0,
            );
             
            if(isset($this->params['named']['reqType']) && $this->params['named']['reqType'] != ''){
                if($this->params['named']['reqType']=='XLS'){
                    $this->layout='export_xls';
                    $this->set('file_type','xls');
                    $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.xls');
                }else if($this->params['named']['reqType']=='DOC'){
                    $this->layout='export_xls';
                    $this->set('file_type','doc');
                    $this->set('file_name','medical_sick_report_'.date('d_m_Y').'.doc');
                }
                $this->set('is_excel','Y');         
                $limit = array('limit' => 2000,'maxLimit'   => 2000);
            }else{
                $limit = array('limit'  => 20);
            }           
            $this->paginate = array(
                'recursive'     => 2,
                'conditions'    => $condition,
                'order'         => array(
                    'InPrisonPunishment.modified'    => 'DESC',
                ),
            )+$limit;
            $datas = $this->paginate('InPrisonPunishment');
            
            
            $this->set(array(
                'datas'         => $datas,
                'prisoner_id'   => $prisoner_id,
                'uuid'          => $uuid,
            ));
        }
     }
      
     public function deletePunishmentsRecords(){
        $this->autoRender = false;

        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'InPrisonPunishment.is_trash'    => 1,
            );
            $conds = array(
                'InPrisonPunishment.uuid'    => $uuid,
            );
            if($this->InPrisonPunishment->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }

 }