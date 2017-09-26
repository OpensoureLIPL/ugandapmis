<?php
App::uses('Controller', 'Controller');

class PrisonsController extends AppController{
   public $layout='table';
    public $uses=array('Prison', 'Mastersecurity', 'Stationcategory','Magisterial','Tier', 'Court');
    /**
     * Index Function
     */
    public function index(){
   
          $datas=$this->Prison->find('all',array(
            'conditions'=>array(
                  'Prison.is_trash'=>0,
              ), 
              'order'=>array(
                  'Prison.name'
              )
          ));
          $this->set(compact('datas'));
    }
    /**
     * Add Function
     */
    public function add(){
        if($this->request->is(array('post','put'))){
          $magisterial_id="";
          $magisterialidget=$this->request->data["Prison"]["magisterial_id"];
          foreach ($magisterialidget as $value) {
            $magisterial_id .=$value.',';
            # code...
          }
          $this->request->data["Prison"]["magisterial_id"]=$magisterial_id;

          $phone_no_list="";
          $phone_nos=$this->request->data["Prison"]["phone"];
          foreach ($phone_nos as $phone_no) {
            $phone_no_list .=$phone_no.',';
          }
          $this->request->data["Prison"]["phone"]=$phone_no_list;

            $this->request->data['Prison']['date_of_opening']=date('Y-m-d',strtotime($this->request->data['Prison']['date_of_opening']));
            if($this->Prison->save($this->request->data)){
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
        // $tier=array(
        //     'Tier 1'=>'Tier 1',
        //     'Tier 2'=>'Tier 2',
        //     'Tier 3'=>'Tier 3',
        //     'Tier 4'=>'Tier 4',
        // );
        $tier=$this->Tier->find('list',array(
                'conditions'=>array(
                  'Tier.is_enable'=>1,
                  'Tier.is_trash'=>0,
                ),
                'order'=>array(
                  'Tier.name'
                )
          ));
          $security_id=$this->Mastersecurity->find('list',array(
                'conditions'=>array(
                  'Mastersecurity.is_enable'=>1,
                  'Mastersecurity.is_trash'=>0,
                ),
                'order'=>array(
                  'Mastersecurity.name'
                )
          ));
          $this->loadModel('Stationcategory');
          $stationcategory_id=$this->Stationcategory->find('list',array(
                'conditions'=>array(
                  'Stationcategory.is_enable'=>1,
                  'Stationcategory.is_trash'=>0,
                ),
                'order'=>array(
                  'Stationcategory.name'
                )
          ));
          $magisterial_id=$this->Magisterial->find('list',array(
                'conditions'=>array(
                  'Magisterial.is_enable'=>1,
                  'Magisterial.is_trash'=>0,
                ),
                'order'=>array(
                  'Magisterial.name'
                )
          ));
        $this->set(compact('is_enable','security_id','stationcategory_id','magisterial_id','tier'));
    }
    /**
     * Edit Function
     */
    public function edit($id){
        $this->layout='table';
        if($this->request->is(array('post','put'))){
          $magisterial_id="";
          $magisterialidget=$this->request->data["Prison"]["magisterial_id"];
          foreach ($magisterialidget as $value) {
            $magisterial_id .=$value.',';
            # code...
          }
          $this->request->data["Prison"]["magisterial_id"]=$magisterial_id;

          $phone_no_list="";
          $phone_nos=$this->request->data["Prison"]["phone"];
          foreach ($phone_nos as $phone_no) {
            $phone_no_list .=$phone_no.',';
          }
          $this->request->data["Prison"]["phone"]=$phone_no_list;
          
          $this->request->data['Prison']['date_of_opening']=date('Y-m-d',strtotime($this->request->data['Prison']['date_of_opening']));
            if($this->Prison->save($this->request->data)){
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
          $security_id=$this->Mastersecurity->find('list',array(
                'conditions'=>array(
                  'Mastersecurity.is_enable'=>1,
                  'Mastersecurity.is_trash'=>0,
                ),
                'order'=>array(
                  'Mastersecurity.name'
                )
          ));
          $this->loadModel('Stationcategory');
          $stationcategory_id=$this->Stationcategory->find('list',array(
                'conditions'=>array(
                  'Stationcategory.is_enable'=>1,
                  'Stationcategory.is_trash'=>0,
                ),
                'order'=>array(
                  'Stationcategory.name'
                )
          ));

          $magisterial_id=$this->Magisterial->find('list',array(
                'conditions'=>array(
                  'Magisterial.is_enable'=>1,
                  'Magisterial.is_trash'=>0,
                ),
                'order'=>array(
                  'Magisterial.name'
                )
          ));
          // $tier=$this->Tier->find('list',array(
          //       'conditions'=>array(
          //         'Tier.is_enable'=>1,
          //         'Tier.is_trash'=>0,
          //       ),
          //       'order'=>array(
          //         'Tier.name'
          //       )
          // ));
        $this->set(compact('is_enable','security_id','stationcategory_id','magisterial_id'));
        $this->request->data=$this->Prison->findById($id);
        $this->request->data['Prison']['date_of_opening']=date('d-m-Y',strtotime($this->request->data['Prison']['date_of_opening']));
    }
    //Detail view of prison
    function detail($id)
    {
      if($id != '')
      {
        $pCount = 0; $courtList = 'N/A';
        $prisonData  = $this->Prison->findById($id);
        if(isset($prisonData) && count($prisonData)>0)
        {
          //get no of prisoners in this station 
          $PrisonerCount = $this->Prisoner->find('all', array(
              
              'recursive'     => -1,
              'fields' => array('count(Prisoner.id)   AS total_amount'),
              'conditions' => array(
                'Prisoner.prison_id'    => $id,
                'Prisoner.is_trash'     => 0
              )
          ));
          if(isset($PrisonerCount[0][0]['total_amount']))
          {
            $pCount = $PrisonerCount[0][0]['total_amount'];
          }
          $capacity = $prisonData['Prison']['capacity'];
          $congestion_level = $capacity - $pCount;
          $prisonData['Prison']['pCount'] = $pCount;
          $prisonData['Prison']['congestion_level'] = $congestion_level;
          if($prisonData['Prison']['magisterial_id'] != '')
          {
            $courtData = $this->Court->find('list', array(
              
                'recursive'     => -1,
                'fields' => array('Court.name'),
                'conditions' => array(
                  'Court.magisterial_id' => $prisonData['Prison']['magisterial_id'],
                  'Court.is_trash'       => 0,
                  'Court.is_enable'      => 1
                ),
            ));  
            if(count($courtData)>0){
              
              $courtList = implode(', ',$courtData);
            }
            // if(count($courtData)== 1) 
            // {
            //   $courtList = $courtData;
            // }
          }
          $this->set(compact('prisonData','courtList'));
          //echo '<pre>'; print_r($courtData); exit;
        }
        else 
        {
          $this->redirect(array('action'=>'index'));
        }
      }
      else 
      {
        $this->redirect(array('action'=>'index'));
      }
    }
    /**
     * Delete Function
     */
    public function delete($id){
        $this->Prison->delete($id);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Deleted Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////
    public function disable($id){
        $this->Prison->id=$id;
        $this->Prison->saveField('is_enable',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////////
    public function enable($id){
        $this->Prison->id=$id;
        $this->Prison->saveField('is_enable',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    public function trash($id){
      $this->Prison->id=$id;
      $this->Prison->updateAll(
            array('Prison.is_trash' => 1),
            array('Prison.id' => $id)
        );
      //$this->Document->saveField('is_trash',1);
      $this->Session->write("message_type",'success');
      $this->Session->write('message','Trashed Successfully !');
      $this->redirect(array(
        'controller'=>'prisons',
        'action'=>'index'
      ));
    }
    public function getMiniMaxVal(){
      $this->autoRender = false;
      $tierid = $this->request->data['tierid'];
       $tier=$this->Tier->find('first',array(
                'conditions'=>array(
                  'Tier.id'=>$tierid,
                  'Tier.is_enable'=>1,
                  'Tier.is_trash'=>0,
                ),
        ));
       $minimum=$tier["Tier"]["minimum"];
       $maximum=$tier["Tier"]["maximum"];
       echo json_encode(array("minimum"=>$minimum,"maximum"=>$maximum));
    }
    public function getTierVal(){
      $this->autoRender = false; 
      $capacity = $this->request->data['capacity'];
      $tier=$this->Tier->find('first',array(
                'conditions'=>array(
                  'Tier.minimum <='=>$capacity,
                  'Tier.maximum >='=>$capacity,
                  'Tier.maximum !='=>0,
                ),
      ));
      if(count($tier)>0)
      {
        $name=$tier["Tier"]["name"];
      }
      else{
        $tier=$this->Tier->find('first',array(
                'conditions'=>array(
                  'Tier.minimum <'=>$capacity,
                 
                ),
          ));
        $name=$tier["Tier"]["name"];
      }

      echo json_encode(array("name"=>$name));
    }
}
