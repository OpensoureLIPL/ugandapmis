<?php
App::uses('Controller', 'Controller');
class PrisonersController extends AppController{
    public $layout='table';
    public $uses=array('User', 'Department', 'Designation', 'Usertype', 'State', 'District', 'Prison', 'Gender', 'Tribe', 'Country','Prisoner','Iddetail','PrisonerIdDetail','PrisonerKinDetail','PrisonerChildDetail','PrisonerAdmissionDetail','PrisonerSentenceDetail','PrisonerSpecialNeed','PrisonerOffenceDetail','PrisonerOffenceCount','PrisonerRecaptureDetail','Offence','SectionOfLaw','Classification','Disability','MaritalStatus');

    //Delete Id proof 
    function deleteIdProof()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerIdDetail.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerIdDetail.id'    => $uuid,
            );
            
            if($this->PrisonerIdDetail->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }

    public function idProofAjax(){
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerIdDetail.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerIdDetail.puuid' => $prisoner_id );
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
                'PrisonerIdDetail.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerIdDetail');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    public function index(){

    }
    public function indexAjax(){
        $this->layout   = 'ajax';
        $prisoner_no    = '';
        $prisoner_name  = '';
        $usertype_id    = $this->Auth->user('usertype_id');
        $condition      = array(
            'Prisoner.is_trash'         => 0,
            'Prisoner.prison_id'        => $this->Auth->user('prison_id')
        );
        if($usertype_id == Configure::read('OFFICERINCHARGE_USERTYPE')){
            $condition      += array(
                'Prisoner.is_final_save'    => 1,
            );            
        }else if($usertype_id == Configure::read('PRINCIPALOFFICER_USERTYPE')){
            $condition      += array(
                'Prisoner.is_verify'    => 1,
            );            
        } 

        if(isset($this->params['named']['prisoner_no']) && $this->params['named']['prisoner_no'] != ''){
            $prisoner_no = $this->params['named']['prisoner_no'];
            $prisonerno = str_replace('-', '/', $prisoner_no);
            $condition += array(1 => "Prisoner.prisoner_no LIKE '%$prisonerno%'");
        }
        if(isset($this->params['named']['prisoner_name']) && $this->params['named']['prisoner_name'] != ''){
            $prisoner_name = $this->params['named']['prisoner_name'];
            $condition += array(2 => "CONCAT(Prisoner.first_name, ' ' , Prisoner.last_name) LIKE '%$prisoner_name%'");
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
            $limit = array('limit'  => 12);
        }

        //echo '<pre>'; print_r($this->params); exit;
                      
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         => array(
                'Prisoner.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('Prisoner');
        $this->set(array(
            'datas'         => $datas,     
            'usertype_id'   => $usertype_id,
            'prisoner_no'   => $prisoner_no,
            'prisoner_name' => $prisoner_name,
        ));
    }
    public function getExt($filename){
        $ext = substr(strtolower(strrchr($filename, '.')), 1);
        return $ext;
    }
    public function getNationName()
    {
      $this->autoRender = false;
      $nationality_name = '';
      if(isset($this->request->data['country_id']) && !empty($this->request->data['country_id']))
      {
          $country_id = $this->request->data['country_id'];
           $country=$this->Country->find('first',array(
                    'conditions'=>array(
                      'Country.id'=>$country_id,
                      'Country.is_enable'=>1,
                      'Country.is_trash'=>0,
                    ),
            ));
           $nationality_name=$country["Country"]["nationality_name"];
      }             
       //echo json_encode(array("nationality_name"=>$nationality_name));
       echo $nationality_name;
    }

    //Get Region list as per selected country START
    public function stateList()
    {
        $this->autoRender = false;
        $country_id = $this->request->data['country_id'];
        $stateHtml = '<option value="">-- Select Region --</option>';
        if(isset($country_id) && (int)$country_id != 0)
        {
            $stateList = $this->State->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'State.id',
                    'State.name',
                ),
                'conditions'    => array(
                    'State.country_id'     => $country_id,
                    'State.is_enable'      => 1,
                    'State.is_trash'       => 0,
                ),
                'order'         => array(
                    'State.name'
                ),
            ));    
            //$stateHtml = '';
            foreach($stateList as $stateKey=>$stateVal)
            {
                $stateHtml .= '<option value="'.$stateKey.'">'.$stateVal.'</option>';
            }
        }
        echo $stateHtml;  
        
    }
    //Get Region list as per selected country END

    //Get section of laws as per selected offence START
    public function getSectionOfLaws()
    {
        $this->autoRender = false;
        $offence_id = $this->request->data['offence_id'];
        $solHtml = '<option value="">-- Select Section Of Law --</option>';
        if(isset($offence_id) && (int)$offence_id != 0)
        {
            $solList = $this->SectionOfLaw->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'SectionOfLaw.id',
                    'SectionOfLaw.name',
                ),
                'conditions'    => array(
                    'SectionOfLaw.offence_id'     => $offence_id,
                    'SectionOfLaw.is_enable'      => 1,
                    'SectionOfLaw.is_trash'       => 0,
                ),
                'order'         => array(
                    'SectionOfLaw.name'
                ),
            ));    
            
            foreach($solList as $solKey=>$solVal)
            {
                $solHtml .= '<option value="'.$solKey.'">'.$solVal.'</option>';
            }
        }
        echo $solHtml;  
        
    }
    //Get Region list as per selected country END
    
    public function prisnorsIdInfo(){

        if($this->request->is(array('post','put'))){

            if(empty($this->request->data['PrisonerIdDetail']['id']))
            {
                $uuid = $this->PrisonerIdDetail->query("select uuid() as code");
                $uuid = $uuid[0][0]['code'];
                $this->request->data['PrisonerIdDetail']['uuid'] = $uuid;
            }            
            
            $prisoner_id=$this->request->data['PrisonerIdDetail']['prisoner_id'];
            $puuid=$this->request->data['PrisonerIdDetail']['puuid'];
            $id_name=$this->request->data['PrisonerIdDetail']['id_name'];
            $id_number=$this->request->data['PrisonerIdDetail']['id_number'];
            $edit_id = $this->request->data['PrisonerIdDetail']['id'];

            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerIdDetail']['login_user_id'] = $login_user_id;  

            //get previous id proof detail 
            $id_proof_detail = $this->PrisonerIdDetail->find('first',array(
                'conditions'=>array(
                  'PrisonerIdDetail.puuid'=>$puuid
                ),
            ));

            //echo '<pre>'; print_r($id_proof_detail); exit;
            if(!empty($id_proof_detail))
            {
                //check id name existance  
                $id_name_validate=$this->PrisonerIdDetail->find('first',array(
                    'conditions'=>array(
                      'PrisonerIdDetail.prisoner_id'=>$prisoner_id,
                      'PrisonerIdDetail.id_name'=>$id_name,
                      'PrisonerIdDetail.is_trash'=>0
                    ),
                ));
                if(count($id_name_validate)>0){

                    if(!empty($edit_id))
                    {
                        //check id no 
                        if($id_number != $id_name_validate['PrisonerIdDetail']['id_number'])
                        {
                            //save id proof details
                            if($this->PrisonerIdDetail->save($this->request->data)){
                                $this->Session->write('message_type','success');
                                $this->Session->write('message','Saved Successfully !');
                                $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                            }
                            else{
                                $this->Session->write('message_type','error');
                                $this->Session->write('message','Saving Failed !'); 
                                $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                            }
                        }
                        else 
                        {
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Saving Failed ! Id name already exist');
                            $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                        }
                    }
                    else 
                    {
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed ! Id name already exist');
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                }
                else 
                {
                    //save id proof details
                    if($this->PrisonerIdDetail->save($this->request->data)){
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                    else{
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed !'); 
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                }

                //check id no existance 
                $id_number_validate=$this->PrisonerIdDetail->find('first',array(
                    'conditions'=>array(
                      'PrisonerIdDetail.prisoner_id'=>$prisoner_id,
                      'PrisonerIdDetail.id_number'=>$id_number,
                      'PrisonerIdDetail.trash'=>0
                    ),
                ));
                if(count($id_number_validate)>0){

                    if(!empty($edit_id))
                    {
                        //check id no 
                        if($id_name != $id_number_validate['PrisonerIdDetail']['id_name'])
                        {
                            //save id proof details
                            if($this->PrisonerIdDetail->save($this->request->data)){
                                $this->Session->write('message_type','success');
                                $this->Session->write('message','Saved Successfully !');
                                $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                            }
                            else{
                                $this->Session->write('message_type','error');
                                $this->Session->write('message','Saving Failed !'); 
                                $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                            }
                        }
                        else 
                        {
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Saving Failed ! Id number already exist');
                            $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                        }
                    }
                    else 
                    {
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed ! Id number already exist');
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                    
                }
                else 
                {
                    //save id proof details
                    if($this->PrisonerIdDetail->save($this->request->data)){
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                    else{
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed !'); 
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                    }
                }
            }
            else 
            {
                //save id proof details
                if($this->PrisonerIdDetail->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                    $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details'));
                }
            }

            if((count($id_name_validate)>0) && count($id_number_validate)>0){ 
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed ! Id name already exist');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details1'));
            }
            else{
                if(count($id_number_validate)>0){
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed ! Id number already exist'); 
                    $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details2'));
                }
                else{
                    if($this->PrisonerIdDetail->save($this->request->data)){
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details3'));
                    }
                    else{
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed !'); 
                        $this->redirect(array('action'=>'edit/'.$puuid.'#id_proof_details4'));
                    }
                }
            }
        }
    }
    public function prisnoriddetailedit(){
      $this->autoRender = false;
      $prisonerDetailId = $this->request->data['prisonerDetailId'];
       $prisoner_id_details=$this->PrisonerIdDetail->find('first',array(
                'conditions'=>array(
                  'PrisonerIdDetail.id'=>$prisonerDetailId,
                ),
        ));
       $id_name=$prisoner_id_details["PrisonerIdDetail"]["id_name"];
       $id=$prisoner_id_details["PrisonerIdDetail"]["id"];
       $id_number=$prisoner_id_details["PrisonerIdDetail"]["id_number"];
       
       echo json_encode(array("id_name"=>$id_name,"id"=>$id,"id_number"=>$id_number));

    }
    public function add($ex_prisoner_unique_no=''){

        $stateList = '';
        $districtList = '';

        if($ex_prisoner_unique_no != '')
        {
            //get existing prisoner info 
            $ex_prisonerdata = $this->Prisoner->find('first', array(
                'recursive'     => -1,
                'conditions'    => array(
                    'Prisoner.prisoner_unique_no' => $ex_prisoner_unique_no,
                ),
            ));
            $this->request->data['Prisoner'] = $ex_prisonerdata['Prisoner'];
            //echo '<pre>'; print_r($this->request->data['Prisoner']); exit;
            $this->Prisoner->set($this->request->data);
        }
        else 
        {
            if(isset($this->request->data['Prisoner']['exp_photo_name']))
                $this->request->data['Prisoner']['photo'] = $this->request->data['Prisoner']['exp_photo_name'];
            //echo '<pre>'; print_r($this->request->data['Prisoner']); exit;
        }

        if(isset($this->data['Prisoner']) && is_array($this->data['Prisoner']) && count($this->data['Prisoner'])>0){

            $uuid = $this->Prisoner->query("select uuid() as code");
            $uuid = $uuid[0][0]['code'];
            $this->request->data['Prisoner']['uuid'] = $uuid;

            if(!isset($this->request->data['Prisoner']['prisoner_unique_no']))
            {
                $this->request->data['Prisoner']['prisoner_unique_no']  = $uuid.time().rand();
            }
           

            $this->request->data["Prisoner"]["prison_id"]           = $this->Auth->user('prison_id');
            if(isset($this->data['Prisoner']['date_of_birth']) && $this->data['Prisoner']['date_of_birth'] != ''){
                $this->request->data['Prisoner']['date_of_birth']=date('Y-m-d',strtotime($this->data['Prisoner']['date_of_birth']));
            } 
            //Get state list as per selected country START 
            $country_id = $this->request->data["Prisoner"]["country_id"]; 
            if(isset($country_id) && !empty($country_id)) 
            {
                $stateList = $this->State->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'State.id',
                        'State.name',
                    ),
                    'conditions'    => array(
                        'State.country_id'     => $country_id,
                        'State.is_enable'      => 1,
                        'State.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'State.name'
                    ),
                ));    
            }
            //Get state list as per selected country END
            //Get district list as per selected state START
            $state_id = $this->request->data["Prisoner"]["state_id"]; 
            if(isset($state_id) && !empty($state_id)) 
            {
                $districtList = $this->District->find('list', array(
                'recursive'     => -1,
                'fields'        => array(
                    'District.id',
                    'District.name',
                ),
                'conditions'    => array(
                    'District.state_id'     => $state_id,
                    'District.is_enable'    => 1,
                    'District.is_trash'     => 0
                ),
                'order'         => array(
                    'District.name'
                ),
            ));
            }
            //Get district list as per selected state END
            /*
             *Query for get the prison name for generate prisoner no.
             */
            $prisonData = $this->Prison->find('first', array(
                'recursive'     => -1,
                'fields'        => array(
                    'Prison.name',
                ),
                'conditions'    => array(
                    'Prison.id' => $this->data["Prisoner"]["prison_id"],
                ),
            ));
            if(isset($prisonData['Prison']['name']) && $prisonData['Prison']['name'] != ''){
                $prisonName = $prisonData['Prison']['name'];
            }else{
                $prisonName = 'DEFAULT';
            }
            if($ex_prisoner_unique_no == '')
            {
                unset($this->request->data['Prisoner']['exp_photo_name']);

                $db = ConnectionManager::getDataSource('default');
                $db->begin(); 

                if(is_string($this->request->data['Prisoner']['photo']))
                    unset($this->Prisoner->validate['photo']);
                
                $pdata['Prisoner'] = $this->data['Prisoner'];
                //echo '<pre>'; print_r($pdata);exit; 
                if($this->Prisoner->save( $this->data)){

                    $prisoner_id    = $this->Prisoner->id;
                    $prisoner_no    = strtoupper(substr($prisonName, 0, 3)).'/'.str_pad($prisoner_id,6,'0',STR_PAD_LEFT) .'/'.date('Y');
                    $fields = array(
                        'Prisoner.prisoner_no'  => "'$prisoner_no'",
                    );
                    $conds = array(
                        'Prisoner.id'       => $prisoner_id,
                    );
                    if($this->Prisoner->updateAll($fields, $conds)){

                        //Insert all information of existing prisoner
                        //check if prisoner is existing START
                        $extPrisonerData  = $this->Prisoner->find('first', array(
                            'recursive'     => -1,
                            'conditions'    => array(
                                'Prisoner.prisoner_unique_no'   => $this->data['Prisoner']['prisoner_unique_no']
                            )
                        ));

                        //echo '<pre>'; print_r($extPrisonerData); exit;

                        if(!empty($extPrisonerData) && count($extPrisonerData)>0 && isset($extPrisonerData['Prisoner']['uuid']))
                        {
                            //get existing prisoner admission details 
                            $admissionData      = $this->PrisonerAdmissionDetail->find('first', array(
                                'recursive'     => -1,
                                'conditions'    => array(
                                    'PrisonerAdmissionDetail.puuid'  => $extPrisonerData['Prisoner']['uuid']
                                )
                            ));
                            unset($admissionData['PrisonerAdmissionDetail']['id']);
                            $admissionData['PrisonerAdmissionDetail']['puuid'] = $this->data['Prisoner']['uuid'];
                            $admissionData['PrisonerAdmissionDetail']['prisoner_no'] = $prisoner_no;
                            $admissionData['PrisonerAdmissionDetail']['prisoner_id'] = $prisoner_id;

                            $ad_uuid = $this->PrisonerAdmissionDetail->query("select uuid() as code");
                            $ad_uuid = $ad_uuid[0][0]['code'];
                            $admissionData['PrisonerAdmissionDetail']['uuid'] = $ad_uuid;

                            $this->PrisonerAdmissionDetail->save($admissionData);
                            //echo '<pre>'; print_r($admissionData); exit;
                            //get existing prisoner admission sentence details 
                            $sentenceData      = $this->PrisonerSentenceDetail->find('first', array(
                                'recursive'     => -1,
                                'conditions'    => array(
                                    'PrisonerSentenceDetail.puuid'      => $extPrisonerData['Prisoner']['uuid'],
                                    'PrisonerSentenceDetail.sentence_type'    => 'admission'
                                )
                            ));
                            unset($sentenceData['PrisonerSentenceDetail']['id']);
                            $sentenceData['PrisonerSentenceDetail']['puuid'] = $this->data['Prisoner']['uuid'];
                            $sentenceData['PrisonerSentenceDetail']['prisoner_no'] = $prisoner_no;
                            $sentenceData['PrisonerSentenceDetail']['prisoner_id'] = $prisoner_id;

                            $sen_uuid = $this->PrisonerSentenceDetail->query("select uuid() as code");
                            $sen_uuid = $sen_uuid[0][0]['code'];
                            $sentenceData['PrisonerSentenceDetail']['uuid'] = $sen_uuid;

                            $this->PrisonerSentenceDetail->save($sentenceData);

                            //get existing prisoner id proof details 
                            $idproofData      = $this->PrisonerIdDetail->find('all', array(
                                'conditions'    => array(
                                    'PrisonerIdDetail.puuid'      => $extPrisonerData['Prisoner']['uuid'],
                                    'PrisonerIdDetail.is_trash'    => 0
                                )
                            ));
                            if(count($idproofData) > 0)
                            {
                                foreach($idproofData as $idkey=>$idval)
                                {
                                    $pidData = '';
                                    $pidData['PrisonerIdDetail'] = $idval['PrisonerIdDetail'];
                                    unset($pidData['PrisonerIdDetail']['id']);
                                    $pidData['PrisonerIdDetail']['puuid'] = $this->data['Prisoner']['uuid'];
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
                                    'PrisonerKinDetail.puuid'      => $extPrisonerData['Prisoner']['uuid'],
                                    'PrisonerKinDetail.is_trash'    => 0
                                )
                            ));
                            if(count($kinDataList) > 0)
                            {
                                foreach($kinDataList as $kinDatakey=>$kinDataval)
                                {
                                    $kinData = '';
                                    $kinData['PrisonerKinDetail'] = $kinDataval['PrisonerKinDetail'];
                                    unset($kinData['PrisonerKinDetail']['id']);
                                    $kinData['PrisonerKinDetail']['puuid'] = $this->data['Prisoner']['uuid'];
                                    $kinData['PrisonerKinDetail']['prisoner_id'] = $prisoner_no;
                                    $kinData['PrisonerKinDetail']['prisoner_id'] = $prisoner_id;

                                    $kin_uuid = $this->PrisonerKinDetail->query("select uuid() as code");
                                    $kin_uuid = $kin_uuid[0][0]['code'];
                                    $kinData['PrisonerKinDetail']['uuid'] = $kin_uuid;

                                    $this->PrisonerKinDetail->save($kinData);
                                }
                            }
                            //get existing prisoner special needs
                            $snDataList      = $this->PrisonerSpecialNeed->find('all', array(
                                'conditions'    => array(
                                    'PrisonerSpecialNeed.puuid'      => $extPrisonerData['Prisoner']['uuid'],
                                    'PrisonerSpecialNeed.is_trash'    => 0
                                )
                            ));
                            if(count($snDataList) > 0)
                            {
                                foreach($snDataList as $snDatakey=>$snDataDataval)
                                {
                                    $snData = '';
                                    $snData['PrisonerSpecialNeed'] = $snDataDataval['PrisonerSpecialNeed'];
                                    unset($snData['PrisonerSpecialNeed']['id']);
                                    $snData['PrisonerSpecialNeed']['puuid'] = $this->data['Prisoner']['uuid'];
                                    $snData['PrisonerSpecialNeed']['prisoner_id'] = $prisoner_no;
                                    $snData['PrisonerSpecialNeed']['prisoner_id'] = $prisoner_id;

                                    $sn_uuid = $this->PrisonerSpecialNeed->query("select uuid() as code");
                                    $sn_uuid = $sn_uuid[0][0]['code'];
                                    $snData['PrisonerSpecialNeed']['uuid'] = $sn_uuid;

                                    $this->PrisonerSpecialNeed->save($snData);
                                }
                            }
                        }
                        //check if prisoner is existing END

                        $db->commit();
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('action'=>'index'));                    
                    }else{
                        $db->rollback();
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed !');                    
                    }
                }else{
                    //debug($this->Prisoner->validationErrors);
                    //exit;
                    $db->rollback();
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !');
                }
            }
            
        }
        
        $genderList = $this->Gender->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Gender.id',
                'Gender.name',
            ),
            'conditions'    => array(
                'Gender.is_enable'      => 1,
                'Gender.is_trash'       => 0,
            ),
            'order'         => array(
                'Gender.name'
            ),
        ));
        $classificationList = $this->Classification->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Classification.id',
                'Classification.name',
            ),
            'conditions'    => array(
                'Classification.is_enable'      => 1,
                'Classification.is_trash'       => 0,
            ),
            'order'         => array(
                'Classification.name'
            ),
        ));
        $countryList = $this->Country->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Country.id',
                'Country.name',
            ),
            'conditions'    => array(
                'Country.is_enable'      => 1,
                'Country.is_trash'       => 0,
            ),
            'order'         => array(
                'Country.name'
            ),
        ));
        $tribeList      = $this->Tribe->find('list', array(
            'recursive'     => -1,
            'fields'        => array(
                'Tribe.id',
                'Tribe.name',
            ),
            'conditions'    => array(
                'Tribe.is_enable'      => 1,
                'Tribe.is_trash'       => 0,
            ),
            'order'         => array(
                'Tribe.name'
            ),
        ));
        $this->set(array(
            'genderList'    => $genderList,
            'countryList'   => $countryList,
            'stateList'     => $stateList,
            'tribeList'     => $tribeList,
            'districtList'  => $districtList,
            'classificationList' => $classificationList
        ));
    }
    public function edit($id)
    {
        //check prisoner uuid
        if(!empty($id))
        {
            $uuidAr     = explode('#', $id);
            $puuid   = $uuidAr[0];
            //check prisoner existance
            $prisonerdata = $this->Prisoner->find('first', array(
                'recursive'     => -1,
                'conditions'    => array(
                    'Prisoner.uuid' => $puuid,
                ),
            ));
            $ofnc_soLawList  = '';
            if(isset($prisonerdata['Prisoner']['id']) && (int)$prisonerdata['Prisoner']['id'] != 0)
            {
                //save prisoner details
                if($this->request->is(array('post','put')))
                {
                    unset($this->Prisoner->validate['photo']);
                    if(isset($this->request->data['Prisoner']['photo']))
                    {
                        if(is_array($this->request->data['Prisoner']['photo']))
                        {
                            if(empty($this->request->data['Prisoner']['photo']['name']))
                                unset($this->request->data['Prisoner']['photo']);
                        }  
                    }
                    
                    //check edit
                    $pdata_type = '';
                    // if(isset($this->request->data['PrisonerOffence']))
                    // {
                    //     $offence_id = $this->request->data['PrisonerOffence']['offence_count_id'];
                    // }
                    if(isset($this->request->data['PrisonerDataEdit']))
                    {
                        $pdata_type = $this->request->data['PrisonerDataEdit']['pdata_type'];
                        $pdata_id = $this->request->data['PrisonerDataEdit']['id'];
                        //Edit id proof
                        if($pdata_type == 'PrisonerIdDetail')
                        {
                            $this->request->data  = $this->PrisonerIdDetail->findById($pdata_id);
                        } 
                        //Edit kin detail
                        if($pdata_type == 'PrisonerKinDetail')
                        {
                            $this->request->data  = $this->PrisonerKinDetail->findById($pdata_id);
                        } 
                        //Edit child detail
                        if($pdata_type == 'PrisonerChildDetail')
                        {
                            $this->request->data  = $this->PrisonerChildDetail->findById($pdata_id);
                            $this->request->data['PrisonerChildDetail']['dob'] = date('d-m-Y', strtotime($this->request->data['PrisonerChildDetail']['dob']));
                            $this->request->data['PrisonerChildDetail']['handover_dt'] = date('d-m-Y', strtotime($this->request->data['PrisonerChildDetail']['handover_dt']));
                        } 
                        //Edit child detail
                        if($pdata_type == 'PrisonerSpecialNeed')
                        {
                            $this->request->data  = $this->PrisonerSpecialNeed->findById($pdata_id);
                        } 
                        //Edit child detail
                        if($pdata_type == 'PrisonerOffenceDetail')
                        {
                            $this->request->data  = $editPrisonerOffenceDetail = $this->PrisonerOffenceDetail->findById($pdata_id);
                            //Get section of laws as per selected offence START
                            
                            if(isset($editPrisonerOffenceDetail["PrisonerOffenceDetail"]["offence"]))
                            {
                                if(isset($editPrisonerOffenceDetail["PrisonerOffenceDetail"]["offence"]) && !empty($editPrisonerOffenceDetail["PrisonerOffenceDetail"]["offence"])) 
                                {
                                    $ofnc_soLawList  = $this->SectionOfLaw->find('list', array(
                                        'recursive'     => -1,
                                        'fields'        => array(
                                            'SectionOfLaw.id',
                                            'SectionOfLaw.name',
                                        ),
                                        'conditions'    => array(
                                            'SectionOfLaw.offence_id'     => $editPrisonerOffenceDetail["PrisonerOffenceDetail"]["offence"],
                                            'SectionOfLaw.is_enable'    => 1,
                                            'SectionOfLaw.is_trash'     => 0
                                        ),
                                        'order'         => array(
                                            'SectionOfLaw.name'
                                        ),
                                    ));
                                    //echo '<pre>'; print_r($ofnc_soLawList);
                                }
                            }
                            $this->request->data['PrisonerOffenceDetail']['date_of_commital'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceDetail']['date_of_commital']));
                        } 
                        //Edit child detail
                        if($pdata_type == 'PrisonerOffenceCount')
                        {
                            $this->request->data  = $editPrisonerOffenceCountData = $this->PrisonerOffenceCount->findById($pdata_id);
                            //get offence sentence data
                            $this->request->data['Offence']      = $this->PrisonerSentenceDetail->find('first', array(
                                'recursive'     => -1,
                                'conditions'    => array(
                                    'PrisonerSentenceDetail.puuid'      => $editPrisonerOffenceCountData['PrisonerOffenceCount']['puuid'],
                                    'PrisonerSentenceDetail.sentence_type'    => 'offence',
                                    'PrisonerSentenceDetail.offence_id' => $editPrisonerOffenceCountData['PrisonerOffenceCount']['id']
                                )
                            ));
                            $this->request->data['PrisonerOffenceCount']['date_of_commital'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceCount']['date_of_commital']));
                            $this->request->data['PrisonerOffenceCount']['date_of_sentence'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceCount']['date_of_sentence']));
                            $this->request->data['PrisonerOffenceCount']['date_of_conviction'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceCount']['date_of_conviction']));
                            $this->request->data['PrisonerOffenceCount']['date_of_confirmation'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceCount']['date_of_confirmation']));
                            $this->request->data['PrisonerOffenceCount']['date_of_dismissal_appeal'] = date('d-m-Y', strtotime($this->request->data['PrisonerOffenceCount']['date_of_dismissal_appeal']));
                        } 
                        //Edit child detail
                        if($pdata_type == 'PrisonerRecaptureDetail')
                        {
                            $this->request->data  = $this->PrisonerRecaptureDetail->findById($pdata_id);
                            $this->request->data['PrisonerRecaptureDetail']['escape_date'] = date('d-m-Y', strtotime($this->request->data['PrisonerRecaptureDetail']['escape_date']));
                            $this->request->data['PrisonerRecaptureDetail']['recapture_date'] = date('d-m-Y', strtotime($this->request->data['PrisonerRecaptureDetail']['recapture_date']));
                        } 
                    }
                    else
                    {
                       // echo '<pre>'; print_r($this->request->data); exit;
                        $this->request->data["Prisoner"]["prison_id"] = $this->Session->read('Auth.User.prison_id');

                        $this->request->data['Prisoner']['date_of_birth']=date('Y-m-d',strtotime($this->request->data['Prisoner']['date_of_birth']));
                        
                        if($this->Prisoner->save($this->request->data)){
                            

                            $this->Session->write('message_type','success');
                            $this->Session->write('message','Saved Successfully !');
                            $this->redirect(array('action'=>'edit/'.$id.'#personal_info'));
                        }
                        else{
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Saving Failed !');
                        }
                    }
                    
                }
                //get gender list 
                $genderList = $this->Gender->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Gender.id',
                        'Gender.name',
                    ),
                    'conditions'    => array(
                        'Gender.is_enable'      => 1,
                        'Gender.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Gender.name'
                    ),
                ));
                //get country list 
                $countryList = $this->Country->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Country.id',
                        'Country.name',
                    ),
                    'conditions'    => array(
                        'Country.is_enable'      => 1,
                        'Country.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Country.name'
                    ),
                ));
                //get tribe list 
                $tribeList      = $this->Tribe->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Tribe.id',
                        'Tribe.name',
                    ),
                    'conditions'    => array(
                        'Tribe.is_enable'      => 1,
                        'Tribe.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Tribe.name'
                    ),
                ));
                //get id proof list 
                $id_name      = $this->Iddetail->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Iddetail.id',
                        'Iddetail.name',
                    ),
                    'conditions'    => array(
                        'Iddetail.is_enable'      => 1,
                        'Iddetail.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Iddetail.name'
                    ),
                ));

                //get prisoner data 
                $prisonerData  = $this->Prisoner->find('first', array(
                    
                    'conditions'    => array(
                        'Prisoner.uuid'      => $id
                    )
                ));
                $this->request->data['Prisoner'] = $prisonerData['Prisoner'];
                $this->request->data['Gender'] = $prisonerData['Gender'];
                $this->request->data['Country'] = $prisonerData['Country'];
                $this->request->data['State'] = $prisonerData['State'];
                $this->request->data['District'] = $prisonerData['District'];
                //echo '<pre>'; print_r($prisonerData); exit;
                //get prisoner admission details 
                $admissionData      = $this->PrisonerAdmissionDetail->find('first', array(
                    'recursive'     => -1,
                    'conditions'    => array(
                        'PrisonerAdmissionDetail.puuid'      => $id
                    )
                ));
                //check if prisoner is existing 
                $extPrisonerData  = $this->Prisoner->find('first', array(
                    'recursive'     => -1,
                    'conditions'    => array(
                        'Prisoner.prisoner_unique_no'   => $prisonerData['Prisoner']['prisoner_unique_no']
                    )
                ));
                if(empty($admissionData) && !empty($extPrisonerData))
                {
                    //get existing prisoner admission details 
                    $admissionData      = $this->PrisonerAdmissionDetail->find('first', array(
                        'recursive'     => -1,
                        'conditions'    => array(
                            'PrisonerAdmissionDetail.puuid'  => $extPrisonerData['Prisoner']['uuid']
                        )
                    ));
                    unset($admissionData['PrisonerAdmissionDetail']['id']);
                    unset($admissionData['PrisonerAdmissionDetail']['puuid']);
                }
                
                if(isset($admissionData['PrisonerAdmissionDetail']) && count($admissionData['PrisonerAdmissionDetail'])>0)
                {
                    $admissionData = $admissionData['PrisonerAdmissionDetail'];
                    if($admissionData['date_of_committal'] != '0000-00-00')
                        $admissionData['date_of_committal']=date('d-m-Y',strtotime($admissionData['date_of_committal']));
                    else 
                        $admissionData['date_of_committal'] = '';

                    if($admissionData['date_of_sentence'] != '0000-00-00')
                        $admissionData['date_of_sentence']=date('d-m-Y',strtotime($admissionData['date_of_sentence']));
                    else 
                        $admissionData['date_of_sentence'] = '';

                    if($admissionData['date_of_conviction'] != '0000-00-00')
                        $admissionData['date_of_conviction']=date('d-m-Y',strtotime($admissionData['date_of_conviction']));
                    else 
                        $admissionData['date_of_conviction'] = '';
                }

                $this->request->data['PrisonerAdmissionDetail'] = $admissionData;
                //get admission sentence data
                $sentenceData      = $this->PrisonerSentenceDetail->find('first', array(
                    'recursive'     => -1,
                    'conditions'    => array(
                        'PrisonerSentenceDetail.puuid'      => $id,
                        'PrisonerSentenceDetail.sentence_type'    => 'admission'
                    )
                ));
                //echo '<pre>'; print_r($sentenceData); exit;
                if(empty($sentenceData) && !empty($extPrisonerData))
                {
                    //get existing prisoner admission details 
                    $sentenceData      = $this->PrisonerSentenceDetail->find('first', array(
                        'recursive'     => -1,
                        'conditions'    => array(
                            'PrisonerSentenceDetail.puuid'      => $extPrisonerData['Prisoner']['uuid'],
                            'PrisonerSentenceDetail.sentence_type'    => 'admission'
                        )
                    ));
                    unset($admissionData['PrisonerSentenceDetail']['id']);
                    unset($admissionData['PrisonerSentenceDetail']['puuid']);
                }
                if(isset($sentenceData['PrisonerSentenceDetail']))
                    $sentenceData = $sentenceData['PrisonerSentenceDetail'];

                $this->request->data['PrisonerSentenceDetail'] = $sentenceData;

                //Get state list as per selected country START 
                $stateList = '';
                if(isset($this->data["Prisoner"]["country_id"]))
                {
                    $country_id = $this->data["Prisoner"]["country_id"]; 
                    if(isset($country_id) && !empty($country_id)) 
                    {
                        $stateList = $this->State->find('list', array(
                            'recursive'     => -1,
                            'fields'        => array(
                                'State.id',
                                'State.name',
                            ),
                            'conditions'    => array(
                                'State.country_id'     => $country_id,
                                'State.is_enable'      => 1,
                                'State.is_trash'       => 0,
                            ),
                            'order'         => array(
                                'State.name'
                            ),
                        ));    
                    }
                }
                //Get state list as per selected country END
                //Get district list as per selected state START
                $districtList = '';
                if(isset($this->data["Prisoner"]["state_id"]))
                {
                    $state_id = $this->data["Prisoner"]["state_id"]; 
                    if(isset($state_id) && !empty($state_id)) 
                    {
                        $districtList = $this->District->find('list', array(
                            'recursive'     => -1,
                            'fields'        => array(
                                'District.id',
                                'District.name',
                            ),
                            'conditions'    => array(
                                'District.state_id'     => $state_id,
                                'District.is_enable'    => 1,
                                'District.is_trash'     => 0
                            ),
                            'order'         => array(
                                'District.name'
                            ),
                        ));
                    }
                }
                //Get district list as per selected state END
                //Get all district list START 
                $allDistrictList = $this->District->find('list', array(
                        'recursive'     => -1,
                        'fields'        => array(
                            'District.id',
                            'District.name',
                        ),
                        'conditions'    => array(
                            
                            'District.is_enable'    => 1,
                            'District.is_trash'     => 0
                        ),
                        'order'         => array(
                            'District.name'
                        ),
                    ));
                //Get all district list END 
                //get offence list 
                $offenceList = $this->Offence->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Offence.id',
                        'Offence.name',
                    ),
                    'conditions'    => array(
                        'Offence.is_enable'      => 1,
                        'Offence.is_trash'       => 0,
                        //'Offence.puuid'      => $id,
                    ),
                    'order'         => array(
                        'Offence.name'
                    ),
                ));

                //Get section of laws as per selected offence START
                $soLawList  = '';
                if(isset($this->data["PrisonerAdmissionDetail"]["offence"]))
                {
                    $offence_id = $this->data["PrisonerAdmissionDetail"]["offence"]; 
                    if(isset($offence_id) && !empty($offence_id)) 
                    {
                        $soLawList  = $this->SectionOfLaw->find('list', array(
                            'recursive'     => -1,
                            'fields'        => array(
                                'SectionOfLaw.id',
                                'SectionOfLaw.name',
                            ),
                            'conditions'    => array(
                                'SectionOfLaw.offence_id'     => $offence_id,
                                'SectionOfLaw.is_enable'    => 1,
                                'SectionOfLaw.is_trash'     => 0
                            ),
                            'order'         => array(
                                'SectionOfLaw.name'
                            ),
                        ));
                    }
                }

                //echo '<pre>'; print_r($soLawList); exit;
                //Get section of laws as per selected offence END
                //get classification details 
                $classificationList = $this->Classification->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Classification.id',
                        'Classification.name',
                    ),
                    'conditions'    => array(
                        'Classification.is_enable'      => 1,
                        'Classification.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Classification.name'
                    ),
                ));
                //get disabilities 
                $disabilityList = $this->Disability->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Disability.id',
                        'Disability.name',
                    ),
                    'conditions'    => array(
                        'Disability.is_enable'      => 1,
                        'Disability.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'Disability.name'
                    ),
                ));
                //get offence id list 
                $offenceIdList = $this->PrisonerOffenceDetail->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'PrisonerOffenceDetail.id',
                        'PrisonerOffenceDetail.court_file_no',
                    ),
                    'conditions'    => array(
                        'PrisonerOffenceDetail.is_trash'       => 0,
                        'PrisonerOffenceDetail.puuid'       => $id,
                    ),
                    'order'         => array(
                        'PrisonerOffenceDetail.id'
                    ),
                ));
                //get marital status list 
                $maritalStatusList = $this->MaritalStatus->find('list', array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'MaritalStatus.id',
                        'MaritalStatus.name',
                    ),
                    'conditions'    => array(
                        'MaritalStatus.is_enable'      => 1,
                        'MaritalStatus.is_trash'       => 0,
                    ),
                    'order'         => array(
                        'MaritalStatus.name'
                    ),
                ));
                //echo '<pre>'; print_r($offenceIdList); exit;
                //get yesno options 
                $yesno = array('No','Yes');
                $aplstatus = array('Convicted'=>'Convicted','Non-Convicted'=>'Non-Convicted');
                $prison_id = $this->Auth->user('prison_id');
                $prisonData = $this->Prison->findById($prison_id);
                $this->set(array(
                    'genderList'        => $genderList,
                    'countryList'       => $countryList,
                    'stateList'         => $stateList,
                    'tribeList'         => $tribeList,
                    'allDistrictList'   => $allDistrictList,            
                    'districtList'      => $districtList,
                    'id_name'           => $id_name,
                    'yesno'             => $yesno,
                    'aplstatus'         => $aplstatus,
                    'offenceList'       => $offenceList,
                    'soLawList'         => $soLawList,
                    'ofnc_soLawList'    => $ofnc_soLawList,
                    'classificationList'=> $classificationList,
                    'prison_id'         => $prison_id,
                    'prison_name'       => $prisonData['Prison']['name'],
                    'disabilityList'    => $disabilityList,
                    'offenceIdList'     => $offenceIdList,
                    'maritalStatusList' => $maritalStatusList,
                ));
            }
            else{
                return $this->redirect(array('action' => 'index'));             
            }
        }
        else{
            return $this->redirect(array('action' => 'index'));             
        }
        //echo '<pre>'; print_r($this->data); echo '<pre>'; print_r($yesno); exit;
    }
    public function verifyPrisoner(){
        $this->autoRender = false; 

        $login_user_id = $this->Session->read('Auth.User.id');
        
        if(isset($this->data['uuid']) && $this->data['uuid'] != ''){
            $curDate = date('Y-m-d H:i:s');
            $fields  = array(
                'Prisoner.is_verify'        => 1,
                'Prisoner.verify_date'      => "'$curDate'",
                'Prisoner.verify_by'        => $login_user_id,
            );
            $conds   = array(
                'Prisoner.uuid'               => $this->data['uuid'],
            );
            if($this->Prisoner->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{ 
                echo 'FAIL';
            }
        }else{ 
            echo 'FAIL';
        }
    }
    public function approvePrisoner(){
        $this->autoRender = false;
        $login_user_id = $this->Session->read('Auth.User.id');
        if(isset($this->data['uuid']) && $this->data['uuid'] != ''){
            $curDate = date('Y-m-d H:i:s');
            $fields  = array(
                'Prisoner.is_approve'        => 1,
                'Prisoner.approve_date'      => "'$curDate'",
                'Prisoner.approve_by'        => $login_user_id,
            );
            $conds   = array(
                'Prisoner.uuid'               => $this->data['uuid'],
            );
            if($this->Prisoner->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }   
    //PrisonerKinDetail START
    
    public function prisonerKinDetail()
    {
        
        if($this->request->is(array('post','put'))){

            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerKinDetail']['login_user_id'] = $login_user_id;         
            if(isset($this->request->data['PrisonerKinDetail']['first_name']) && ($this->request->data['PrisonerKinDetail']['first_name'] != ''))
            {
                //create uuid
                if(empty($this->request->data['PrisonerKinDetail']['id']))
                {
                    $uuid = $this->PrisonerKinDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerKinDetail']['uuid'] = $uuid;
                }  
                $puuid=$this->request->data['PrisonerKinDetail']['puuid'];
                if($this->PrisonerKinDetail->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#kin_details'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            } 
        }
    }
    
    public function kinDetailAjax(){
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerKinDetail.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerKinDetail.puuid' => $prisoner_id );
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
                'PrisonerKinDetail.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerKinDetail');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    //Delete Kin 
    function deleteKin()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerKinDetail.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerKinDetail.id'    => $uuid,
            );
            
            if($this->PrisonerKinDetail->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner Kin Detail END  
    //Prisoner Child Detail START
    
    public function prisonerChildDetail()
    {
        
        if($this->request->is(array('post','put'))){
            
            $login_user_id = $this->Session->read('Auth.User.id');
            if(isset($this->request->data['PrisonerChildDetail']['name']) && ($this->request->data['PrisonerChildDetail']['name'] != ''))
            {
                $this->request->data['PrisonerChildDetail']['login_user_id'] = $login_user_id;
                $puuid=$this->request->data['PrisonerChildDetail']['puuid'];

                //create uuid
                if(empty($this->request->data['PrisonerChildDetail']['id']))
                {
                    $uuid = $this->PrisonerChildDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerChildDetail']['uuid'] = $uuid;
                }  

                $this->request->data['PrisonerChildDetail']['dob']=date('Y-m-d',strtotime($this->request->data['PrisonerChildDetail']['dob']));
                $this->request->data['PrisonerChildDetail']['handover_dt']=date('Y-m-d',strtotime($this->request->data['PrisonerChildDetail']['handover_dt']));

                if($this->PrisonerChildDetail->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#child_details'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            } 
        }
    }
    
    public function childDetailAjax(){
        
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerChildDetail.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerChildDetail.puuid' => $prisoner_id );
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
                'PrisonerChildDetail.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerChildDetail');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    //Delete Kin 
    function deleteChild()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerChildDetail.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerChildDetail.id'    => $uuid,
            );
            
            if($this->PrisonerChildDetail->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner Child Detail END  
    //Prisoner Admission & Sentence Details START  

    public function prisonerAdmissionDetail()
    {
        //
        if($this->request->is(array('post','put'))){
             
            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerAdmissionDetail']['login_user_id'] = $login_user_id;  

            if(isset($this->request->data['PrisonerAdmissionDetail']['prisoner_no']) && ($this->request->data['PrisonerAdmissionDetail']['prisoner_no'] != ''))
            {
                $puuid=$this->request->data['PrisonerAdmissionDetail']['puuid'];
                $prisoner_id=$this->request->data['PrisonerAdmissionDetail']['prisoner_id'];
                $prisoner_no=$this->request->data['PrisonerAdmissionDetail']['prisoner_no'];

                //create uuid
                if(empty($this->request->data['PrisonerAdmissionDetail']['id']))
                {
                    $uuid = $this->PrisonerAdmissionDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerAdmissionDetail']['uuid'] = $uuid;
                }  

                //save prisoners admission details 
                $date_of_committal = $this->request->data['PrisonerAdmissionDetail']['date_of_committal']=date('Y-m-d',strtotime($this->request->data['PrisonerAdmissionDetail']['date_of_committal']));
                $date_of_sentence = $this->request->data['PrisonerAdmissionDetail']['date_of_sentence']=date('Y-m-d',strtotime($this->request->data['PrisonerAdmissionDetail']['date_of_sentence']));
                $date_of_conviction = $this->request->data['PrisonerAdmissionDetail']['date_of_conviction']=date('Y-m-d',strtotime($this->request->data['PrisonerAdmissionDetail']['date_of_conviction']));

                //echo '<pre>'; print_r($this->request->data['PrisonerAdmissionDetail']); exit;
                
                $db = ConnectionManager::getDataSource('default');
                $db->begin(); 
                $admissionData['PrisonerAdmissionDetail'] = $this->request->data['PrisonerAdmissionDetail'];
                if($this->PrisonerAdmissionDetail->save($admissionData)){
                    
                    //save prisoners sentence details 
                    if(isset($this->request->data['PrisonerSentenceDetail']) && (count($this->request->data['PrisonerSentenceDetail']) != 0))
                    {
                        //Enter offence details 
                        $offenceData = '';
                        $offenceData['PrisonerOffenceDetail']['prisoner_id'] = $prisoner_id;
                        $offenceData['PrisonerOffenceDetail']['prisoner_no'] = $prisoner_no;
                        $offenceData['PrisonerOffenceDetail']['puuid'] = $puuid;
                        $offenceData['PrisonerOffenceDetail']['login_user_id'] = $login_user_id;
                        $offenceData['PrisonerOffenceDetail']['personal_no'] = $this->request->data['PrisonerAdmissionDetail']['personal_no'];
                        $offenceData['PrisonerOffenceDetail']['offence'] = $this->request->data['PrisonerAdmissionDetail']['offence'];
                        $offenceData['PrisonerOffenceDetail']['section_of_law'] = $this->request->data['PrisonerAdmissionDetail']['section_of_law'];
                        $offenceData['PrisonerOffenceDetail']['court_file_no'] = $this->request->data['PrisonerAdmissionDetail']['court_file_no'];
                        $offenceData['PrisonerOffenceDetail']['case_file_no'] = $this->request->data['PrisonerAdmissionDetail']['case_file_no'];

                        $offenceData['PrisonerOffenceDetail']['crb_no'] = $this->request->data['PrisonerAdmissionDetail']['crb_no'];
                        $offenceData['PrisonerOffenceDetail']['court'] = $this->request->data['PrisonerAdmissionDetail']['court'];
                        $offenceData['PrisonerOffenceDetail']['district_id'] = $this->request->data['PrisonerAdmissionDetail']['district_id'];
                        $offenceData['PrisonerOffenceDetail']['no_of_prev_conviction'] = $this->request->data['PrisonerAdmissionDetail']['no_of_prev_conviction'];
                        $offenceData['PrisonerOffenceDetail']['date_of_committal'] = $date_of_committal;
                        $this->PrisonerOffenceDetail->save($offenceData);

                        //Enter sentence details 
                        $this->request->data['PrisonerSentenceDetail']['prisoner_id'] = $prisoner_id;
                        $this->request->data['PrisonerSentenceDetail']['prisoner_no'] = $prisoner_no;
                        $this->request->data['PrisonerSentenceDetail']['puuid'] = $puuid;
                        $this->request->data['PrisonerSentenceDetail']['login_user_id'] = $login_user_id;

                        $this->request->data['PrisonerSentenceDetail']['date_of_sentence'] = $date_of_sentence;
                        $this->request->data['PrisonerSentenceDetail']['date_of_conviction'] = $date_of_conviction;

                        //calculate LPD & EPD 
                        $years = $this->request->data['PrisonerSentenceDetail']['years'];
                        $months = $this->request->data['PrisonerSentenceDetail']['months'];
                        $days = $this->request->data['PrisonerSentenceDetail']['days'];

                        $total_days = ($years*365)+($months*30)+$days;
                        $total_days_for_lpd = $total_days-1;

                        $lpd_date = date('Y-m-d',strtotime($date_of_conviction) + (24*3600*$total_days_for_lpd));
                        $this->request->data['PrisonerSentenceDetail']['lpd'] = $lpd_date;
                        $this->request->data['PrisonerSentenceDetail']['epd'] = $lpd_date;

                        //calculate remission 
                        $remission = 0;
                        if($total_days > 30)
                        {
                            $remission = ($total_days-30)/3;
                            $remission = ceil($remission);
                            $this->request->data['PrisonerSentenceDetail']['epd'] = date('Y-m-d',strtotime($lpd_date) - (24*3600*$remission));
                        }
                        $this->request->data['PrisonerSentenceDetail']['remission'] = $remission;

                        //create uuid
                        if(empty($this->request->data['PrisonerSentenceDetail']['id']))
                        {
                            $uuid = $this->PrisonerSentenceDetail->query("select uuid() as code");
                            $uuid = $uuid[0][0]['code'];
                            $this->request->data['PrisonerSentenceDetail']['uuid'] = $uuid;
                        }  

                        $sentenceData['PrisonerSentenceDetail'] = $this->request->data['PrisonerSentenceDetail'];
                        if($this->PrisonerSentenceDetail->save($sentenceData)){

                            $db->commit(); 
                            $this->Session->write('message_type','success');
                            $this->Session->write('message','Saved Successfully !');
                            $this->redirect(array('action'=>'edit/'.$puuid.'#admission_details'));
                        }
                        else{
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Saving Failed !'); 
                        }
                    }
                }
                else{ 
                    debug($this->PrisonerAdmissionDetail->validationErrors);
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            } 
        }        
    }

    //Prisoner Admission & Sentence Details END  
    //Prisoner Special Needs START  
    public function prisonerSpecialNeed()
    {        
        if($this->request->is(array('post','put'))){
            
            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerSpecialNeed']['login_user_id'] = $login_user_id; 

            if(isset($this->request->data['PrisonerSpecialNeed']['prisoner_no']) && ($this->request->data['PrisonerSpecialNeed']['prisoner_no'] != ''))
            {
                $puuid = $this->request->data['PrisonerSpecialNeed']['puuid'];

                //create uuid
                if(empty($this->request->data['PrisonerSpecialNeed']['id']))
                {
                    $uuid = $this->PrisonerSpecialNeed->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerSpecialNeed']['uuid'] = $uuid;
                }  

                if($this->PrisonerSpecialNeed->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#special_needs'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            }           
        }
    }

    public function specialNeedAjax(){
        
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerSpecialNeed.is_trash'         => 0,
        );
        $prison_id = $this->Auth->user('prison_id');
        $prisonData = $this->Prison->findById($prison_id);

        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerSpecialNeed.puuid' => $prisoner_id );
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
                'PrisonerSpecialNeed.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerSpecialNeed');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id,
            'prison_name'=>$prisonData['Prison']['name']    
        ));
    }
    //Delete SpecialNeed 
    function deleteSpecialNeed()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerSpecialNeed.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerSpecialNeed.id'    => $uuid,
            );
            
            if($this->PrisonerSpecialNeed->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner Special Needs END
    //Prisoner Offence details START
    function prisonerOffenceDetail()
    {
        if($this->request->is(array('post','put'))){
            
            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerOffenceDetail']['login_user_id'] = $login_user_id; 

            //echo '<pre>'; print_r($this->request->data); exit;  
            if(isset($this->request->data['PrisonerOffenceDetail']['personal_no']) && ($this->request->data['PrisonerOffenceDetail']['personal_no'] != ''))
            {
                //create uuid
                if(empty($this->request->data['PrisonerOffenceDetail']['id']))
                {
                    $uuid = $this->PrisonerOffenceDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerOffenceDetail']['uuid'] = $uuid;
                }  

                $puuid = $this->request->data['PrisonerOffenceDetail']['puuid'];

                $this->request->data['PrisonerOffenceDetail']['date_of_commital']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceDetail']['date_of_commital']));

                if($this->PrisonerOffenceDetail->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#offence_details'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            }           
        }
    }
    public function offenceDetailAjax(){
        
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerOffenceDetail.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerOffenceDetail.puuid' => $prisoner_id );
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
                'PrisonerOffenceDetail.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerOffenceDetail');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    //Delete Offence 
    function deleteOffence()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerOffenceDetail.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerOffenceDetail.id'    => $uuid,
            );
            
            if($this->PrisonerOffenceDetail->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner Offence details END
    //Prisoner Offence count details START
    function prisonerOffenceCount()
    {
        if($this->request->is(array('post','put'))){
            
            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerOffenceCount']['login_user_id'] = $login_user_id; 
            
            if(isset($this->request->data['PrisonerOffenceCount']['offence_id']) && ($this->request->data['PrisonerOffenceCount']['offence_id'] != ''))
            {
                $puuid = $this->request->data['PrisonerOffenceCount']['puuid'];
                $prisoner_id = $this->request->data['PrisonerOffenceCount']['prisoner_id'];
                $prisoner_no = $this->request->data['PrisonerOffenceCount']['prisoner_no'];

                //create uuid
                if(empty($this->request->data['PrisonerOffenceDetail']['id']))
                {
                    $uuid = $this->PrisonerOffenceDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerOffenceDetail']['uuid'] = $uuid;
                }  

                $this->request->data['PrisonerOffenceCount']['date_of_commital']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceCount']['date_of_commital']));
                $date_of_sentence = $this->request->data['PrisonerOffenceCount']['date_of_sentence']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceCount']['date_of_sentence']));
                $date_of_conviction = $this->request->data['PrisonerOffenceCount']['date_of_conviction']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceCount']['date_of_conviction']));
                $this->request->data['PrisonerOffenceCount']['date_of_confirmation']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceCount']['date_of_confirmation']));
                $this->request->data['PrisonerOffenceCount']['date_of_dismissal_appeal']=date('Y-m-d',strtotime($this->request->data['PrisonerOffenceCount']['date_of_dismissal_appeal']));

                $db = ConnectionManager::getDataSource('default');
                $db->begin(); 
                $offenceCountData['PrisonerOffenceCount'] = $this->request->data['PrisonerOffenceCount'];
                if($this->PrisonerOffenceCount->save($offenceCountData)){
                    
                    $offence_id    = $this->PrisonerOffenceCount->id;
                    
                    //save prisoners sentence details 
                    if(isset($this->request->data['Offence']['PrisonerSentenceDetail']) && (count($this->request->data['Offence']['PrisonerSentenceDetail']) != 0))
                    {
                        $this->request->data['Offence']['PrisonerSentenceDetail']['prisoner_id'] = $prisoner_id;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['prisoner_no'] = $prisoner_no;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['puuid'] = $puuid;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['login_user_id'] = $login_user_id;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['offence_id'] = $offence_id; 

                        $this->request->data['Offence']['PrisonerSentenceDetail']['date_of_sentence'] = $date_of_sentence;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['date_of_conviction'] = $date_of_conviction;

                        //calculate LPD & EPD 
                        $years = $this->request->data['Offence']['PrisonerSentenceDetail']['years'];
                        $months = $this->request->data['Offence']['PrisonerSentenceDetail']['months'];
                        $days = $this->request->data['Offence']['PrisonerSentenceDetail']['days'];

                        $total_days = ($years*365)+($months*30)+$days;
                        $total_days_for_lpd = $total_days-1;

                        $lpd_date = date('Y-m-d',strtotime($date_of_conviction) + (24*3600*$total_days_for_lpd));
                        $this->request->data['Offence']['PrisonerSentenceDetail']['lpd'] = $lpd_date;
                        $this->request->data['Offence']['PrisonerSentenceDetail']['epd'] = $lpd_date;

                        //calculate remission 
                        $remission = 0;
                        if($total_days > 30)
                        {
                            $remission = ($total_days-30)/3;
                            $remission = ceil($remission);
                            $this->request->data['Offence']['PrisonerSentenceDetail']['epd'] = date('Y-m-d',strtotime($lpd_date) - (24*3600*$remission));
                        }
                        $this->request->data['Offence']['PrisonerSentenceDetail']['remission'] = $remission;

                        //create uuid
                        if(empty($this->request->data['Offence']['PrisonerSentenceDetail']['id']))
                        {
                            $uuid = $this->PrisonerSentenceDetail->query("select uuid() as code");
                            $uuid = $uuid[0][0]['code'];
                            $this->request->data['Offence']['PrisonerSentenceDetail']['uuid'] = $uuid;
                        }  

                        $offence_sentenceData['PrisonerSentenceDetail'] = $this->request->data['Offence']['PrisonerSentenceDetail'];
                        if($this->PrisonerSentenceDetail->save($offence_sentenceData)){

                            $db->commit(); 
                            $this->Session->write('message_type','success');
                            $this->Session->write('message','Saved Successfully !');
                            $this->redirect(array('action'=>'edit/'.$puuid.'#offence_counts'));
                        }
                        else{
                            $this->Session->write('message_type','error');
                            $this->Session->write('message','Saving Failed !'); 
                        }
                    }
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            }           
        }
    }
    public function offenceCountDetailAjax(){
        
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerOffenceCount.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerOffenceCount.puuid' => $prisoner_id );
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
                'PrisonerOffenceCount.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerOffenceCount');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    //Delete Offence count 
    function deleteOffenceCount()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerOffenceCount.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerOffenceCount.id'    => $uuid,
            );
            
            if($this->PrisonerOffenceCount->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner Offence count details END
    //Prisoner recapture details START
    function prisonerRecaptureDetail()
    {
        if($this->request->is(array('post','put'))){
            
            $login_user_id = $this->Session->read('Auth.User.id');   
            $this->request->data['PrisonerRecaptureDetail']['login_user_id'] = $login_user_id; 
            
            if(isset($this->request->data['PrisonerRecaptureDetail']['prisoner_no']) && ($this->request->data['PrisonerRecaptureDetail']['prisoner_no'] != ''))
            {
                //create uuid
                if(empty($this->request->data['PrisonerRecaptureDetail']['id']))
                {
                    $uuid = $this->PrisonerRecaptureDetail->query("select uuid() as code");
                    $uuid = $uuid[0][0]['code'];
                    $this->request->data['PrisonerRecaptureDetail']['uuid'] = $uuid;
                }  

                $puuid = $this->request->data['PrisonerRecaptureDetail']['puuid'];

                $this->request->data['PrisonerRecaptureDetail']['escape_date']=date('Y-m-d',strtotime($this->request->data['PrisonerRecaptureDetail']['escape_date']));
                $this->request->data['PrisonerRecaptureDetail']['recapture_date']=date('Y-m-d',strtotime($this->request->data['PrisonerRecaptureDetail']['recapture_date']));

                if($this->PrisonerRecaptureDetail->save($this->request->data)){
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved Successfully !');
                    $this->redirect(array('action'=>'edit/'.$puuid.'#recaptured_details'));
                }
                else{
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','Saving Failed !'); 
                }
            }           
        }
    }
    public function recaptureDetailAjax(){
        
        $this->layout   = 'ajax';
        $prisoner_id      = '';
        $condition      = array(
            'PrisonerRecaptureDetail.is_trash'         => 0,
        );
        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != ''){
            $prisoner_id = $this->params['named']['prisoner_id'];
            $condition += array('PrisonerRecaptureDetail.puuid' => $prisoner_id );
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
                'PrisonerRecaptureDetail.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('PrisonerRecaptureDetail');
        $this->set(array(
            'datas'         => $datas,  
            'prisoner_id'=>$prisoner_id    
        ));
    }
    //Delete recapture
    function deleteRecapture()
    {
        $this->autoRender = false;
        if(isset($this->data['paramId'])){
            $uuid = $this->data['paramId'];
            $fields = array(
                'PrisonerRecaptureDetail.is_trash'    => 1,
            );
            $conds = array(
                'PrisonerRecaptureDetail.id'    => $uuid,
            );
            
            if($this->PrisonerRecaptureDetail->updateAll($fields, $conds)){
                echo 'SUCC';
            }else{
                echo 'FAIL';
            }
        }else{
            echo 'FAIL';
        }
    }
    //Prisoner recapture details END
    //Prisoner detail view START 
    public function details($uuid)
    {
        if($uuid){
            $data = $this->Prisoner->find('first', array('conditions' => array('Prisoner.uuid' => $uuid,),));

            if(isset($data['Prisoner']['id']) && (int)$data['Prisoner']['id'] != 0){
            
                $this->set(array('data' => $data,'uuid' => $uuid,));
            }
            else{
            return $this->redirect(array('action' => 'index'));
            }
        }
        else{
            return $this->redirect(array('action' => 'index'));
        }
    }
    //Prisoner detail view END
    //Add Existing Prisoner START
    function existingPrisoner()
    {
        $this->autoRender = false;
        if($this->request->is(array('post','put'))){

            $prisoner_no = $this->request->data['existingPrisoner']['prisoner_no'];
            //check prisoner
            $prisonerdata = $this->Prisoner->find('first', array(
                'recursive'     => -1,
                'conditions'    => array(
                    'Prisoner.prisoner_no' => $prisoner_no,
                ),
            ));
            $prisoner_unique_no = 0;
            if(isset($prisonerdata['Prisoner']) && count($prisonerdata['Prisoner'])>0)
            {
                $prisoner_unique_no = $prisonerdata['Prisoner']['prisoner_unique_no'];
                $this->redirect(array('action'=>'add/'.$prisoner_unique_no));
            }
            else 
            {
                $this->Session->write('message_type','error');
                $this->Session->write('message','Invalid Prisoner Number.');
                $this->redirect(array('action'=>'/'));
            }
        }
        else 
        {
            $this->Session->write('message_type','error');
                $this->Session->write('message','Invalid Prisoner Number.');
                $this->redirect(array('action'=>'/'));
        }
        //echo $uuid;exit;
    }
    //Add Existing Prisoner END
    //Trash prisoner START
    public function trashPrisoner(){
        $this->autoRender = false;
        if(isset($this->data['uuid']) && $this->data['uuid'] != ''){
            $uuid = $this->data['uuid'];
            $data = $this->Prisoner->find('first', array('conditions' => array('Prisoner.uuid' => $uuid,),));
            if(isset($data['Prisoner']['id']) && (int)$data['Prisoner']['id'] != 0){
                $fields = array('Prisoner.is_trash' => 1,);
                $conds = array('Prisoner.id' => $data['Prisoner']['id'],);
                if($this->Prisoner->updateAll($fields, $conds)){
                    echo 'SUCC';
                }
                else{
                    echo 'FAIL';
                }
            }
            else{echo 'FAIL';}
        }
        else{
                echo 'FAIL';
        }
    }
    //Trash prisoner END
    //Final Save prisoner START
    public function finalSavePrisoner(){
        $this->autoRender = false;
        $login_user_id = $this->Session->read('Auth.User.id');
        if(isset($this->data['uuid']) && $this->data['uuid'] != ''){
            $uuid = $this->data['uuid'];
            $data = $this->Prisoner->find('first', array('conditions' => array('Prisoner.uuid' => $uuid,),));
            if(isset($data['Prisoner']['id']) && (int)$data['Prisoner']['id'] != 0){ 

                $curDate = date('Y-m-d H:i:s');
                $fields = array(
                    'Prisoner.is_final_save' => 1,
                    'Prisoner.final_save_date' => "'$curDate'",
                    'Prisoner.final_save_by' => $login_user_id,
                );
                $conds = array('Prisoner.id' => $data['Prisoner']['id'],);
                if($this->Prisoner->updateAll($fields, $conds)){
                    echo 'SUCC';
                }
                else{
                    echo 'FAIL';
                }
            }
            else{echo 'FAIL';}
        }
        else{
                echo 'FAIL';
        }
    }
    //Final Save prisoner END

    //get common data

    public function getCommonHeder()
    {
      $this->layout = 'ajax';
       

        if(isset($this->params['named']['prisoner_id']) && $this->params['named']['prisoner_id'] != 0 && isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
            $uuid = $this->params['named']['uuid'];
            $data = $this->Prisoner->find('first', array('conditions' => array('Prisoner.uuid' => $uuid,),));
            if(isset($data['Prisoner']['id']) && (int)$data['Prisoner']['id'] != 0){
            
                $this->set(array('data' => $data,'uuid' => $uuid,));

                //debug($data);
            }
            else{
            return $this->redirect(array('action' => 'index'));
            }
        }
        else{
            return $this->redirect(array('action' => 'index'));
        }
         $this ->render('Common_header/index');
    }
}