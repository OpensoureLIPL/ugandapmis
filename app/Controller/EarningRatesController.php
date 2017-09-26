<?php
App::uses('AppController', 'Controller');
class EarningRatesController   extends AppController {
    public $layout='table';
    public $uses=array('EarningRate','EarningGrade','EarningRateHistory','Prisoner','EarningRatePrisoner');
    public function index(){
        /*
        *code add the earning rates
        */
      if(isset($this->data['EarningRate']) && is_array($this->data['EarningRate']) && $this->data['EarningRate']!='')
      {
         if(isset($this->data['EarningRate']['uuid']) && $this->data['EarningRate']['uuid']=='')
         {
            $uuidArr=$this->EarningRate->query("select uuid() as code");
            $this->request->data['EarningRate']['uuid']=$uuidArr[0][0]['code'];
         }  
         if(isset($this->data['EarningRate']['start_date']) && $this->data['EarningRate']['start_date']!="" )
         {
            $this->request->data['EarningRate']['start_date']=date('Y-m-d',strtotime($this->data['EarningRate']['start_date']));
         }
         if(isset($this->data['EarningRate']['end_date']) && $this->data['EarningRate']['end_date']!="" )
         {
            $this->request->data['EarningRate']['end_date']=date('Y-m-d',strtotime($this->data['EarningRate']['end_date']));
         } 
         $dataArr['EarningRateHistory']['earning_grade_id']=$this->data['EarningRate']['earning_grade_id'];
         $dataArr['EarningRateHistory']['amount']=$this->data['EarningRate']['amount'];
         $dataArr['EarningRateHistory']['uuid']=$this->data['EarningRate']['uuid'];
         $dataArr['EarningRateHistory']['start_date']=$this->data['EarningRate']['start_date'];
         $dataArr['EarningRateHistory']['end_date']=$this->data['EarningRate']['end_date'];
         $db = ConnectionManager::getDataSource('default');
         $db->begin(); 
         if($this->EarningRate->save($this->data))
         {

             //debug($this->getGradeName($this->EarningRate->id));
            
           
            $dataArr['EarningRateHistory']['earning_rate_id']=$this->EarningRate->id;
            if($this->EarningRateHistory->save($dataArr))
            {
            $db->commit();
            $this->Session->write('message_type','success');
            $this->Session->write('message','Saved successfully');
            $this->redirect('/earningRates');
            }
            else{
            $db->rollback();
            $this->Session->write('message_type','error');
            $this->Session->write('message','saving failed');
            }
         } 
         else{
            $this->Session->write('message_type','error');
            $this->Session->write('message','saving failed');

         }
      }
      
        /*
         *Code for delete the Earning Rates
         */
        if(isset($this->data['EarningRateDelete']['id']) && (int)$this->data['EarningRateDelete']['id'] != 0){
            $this->EarningRate->id=$this->data['EarningRateDelete']['id'];
            $this->EarningRate->saveField('is_trash',1);

            $this->Session->write('message_type','success');
            $this->Session->write('message','Deleted Successfully !');
            $this->redirect(array('action'=>'index'));
        }
        /*
         *Code for edit the Earning Rates
         */
        if(isset($this->data['EarningRateEdit']['id']) && (int)$this->data['EarningRateEdit']['id'] != 0){
            if($this->EarningRate->exists($this->data['EarningRateEdit']['id'])){
                $this->data = $this->EarningRate->findById($this->data['EarningRateEdit']['id']);
            }
        }

     $gradeslist=$this->EarningGrade->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'EarningGrade.id',
                        'EarningGrade.name',
                    ),
                    'conditions'    => array(
                        'EarningGrade.is_enable'    => 1,
                        'EarningGrade.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'EarningGrade.name'
                    )
                ));     
          $this->set(compact('gradeslist'));
    }
    public function indexAjax()
     {
        $this->layout='ajax';
        $condition= array('EarningRate.is_trash'=>0,'EarningRate.is_enable'=>1);

        $this->paginate=array(
            'conditions' =>$condition,
             'order'     => array(
              'EarningRate.modified'=>'DESC' 
              ),
             
            'limit'     =>20
            );

         $datas=$this->paginate('EarningRate');
         $this->set(array(
                'datas' =>$datas
            ));

     }
    public function history()
     {
         $gradeslist=$this->EarningGrade->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'EarningGrade.id',
                        'EarningGrade.name',
                    ),
                    'conditions'    => array(
                        'EarningGrade.is_enable'    => 1,
                        'EarningGrade.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'EarningGrade.name'
                    )
                ));     
          $this->set(compact('gradeslist'));

     }
     public function historyAjax()
     {
        $this->layout='ajax';
         $condition= array();
          $earning_grade_id="";
          $amount="";
          $start_date="";
          $end_date="";


         if(isset($this->params['named']['earning_grade_id']) && $this->params['named']['earning_grade_id'] != ''){
            $earning_grade_id = $this->params['named']['earning_grade_id'];
            $condition += array(0=> "EarningRateHistory.earning_grade_id = $earning_grade_id");
         } 
         if(isset($this->params['named']['amount']) && $this->params['named']['amount'] != ''){
            $amount = $this->params['named']['amount'];
            $condition += array(0=> "EarningRateHistory.amount = $amount");
         } 
         if(isset($this->params['named']['start_date']) && $this->params['named']['start_date'] != ''){
            $start_date = $this->params['named']['start_date'];
            $condition += array(0=> "EarningRateHistory.start_date = $start_date");
         } 
         if(isset($this->params['named']['end_date']) && $this->params['named']['end_date'] != ''){
            $enddate = $this->params['named']['end_date'];
            $condition += array(0=> "EarningRateHistory.end_date = $end_date");
         } 
        $this->paginate=array(
            'conditions' =>$condition,
             'order'     => array(
              'EarningRateHistory.modified'=>'DESC' 
              ),
            'limit'     =>20
            );

         $datas=$this->paginate('EarningRateHistory');
         $this->set(array(
                'datas' =>$datas,
                'earning_grade_id'=>$earning_grade_id,
                'start_date'=>$start_date,
                'end_date'  =>$end_date,
                'amount'    =>$amount
            ));

     }
     public function assignGrades()
     {

        /*
        *Code To save assigned grades to prisoner
        */
        if(isset($this->data['EarningRatePrisoner']) && is_array($this->data['EarningRatePrisoner']) && $this->data['EarningRatePrisoner']!='')
             {
                if(isset($this->data['EarningRatePrisoner']['uuid']) && $this->data['EarningRatePrisoner']['uuid']=='')
                 {
                    $uuidArr=$this->EarningRatePrisoner->query("select uuid() as code");
                    $this->request->data['EarningRatePrisoner']['uuid']=$uuidArr[0][0]['code'];
                 } 
                 if(isset($this->data['EarningRatePrisoner']['date_of_assignment']) && $this->data['EarningRatePrisoner']['date_of_assignment']!="" )
                 {
                    $this->request->data['EarningRatePrisoner']['date_of_assignment']=date('Y-m-d',strtotime($this->data['EarningRatePrisoner']['date_of_assignment']));
                 }
                 if($this->EarningRatePrisoner->save($this->data))
                 {
                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Saved successfully');
                    $this->redirect('/earningRates/assignGrades'); 
                 } 
                else
                 {
                    $this->Session->write('message_type','error');
                    $this->Session->write('message','saving failed');
                 }

             }
             /*
             *Code for delete the Earning Rates
             */
            if(isset($this->data['EarningRatePrisonerDelete']['id']) && (int)$this->data['EarningRatePrisonerDelete']['id'] != 0){
                $this->EarningRatePrisoner->id=$this->data['EarningRatePrisonerDelete']['id'];
                $this->EarningRatePrisoner->saveField('is_trash',1);

                $this->Session->write('message_type','success');
                $this->Session->write('message','Deleted Successfully !');
                $this->redirect(array('action'=>'assignGrades'));
            }
            /*
             *Code for edit the Earning Rates
             */
            if(isset($this->data['EarningRatePrisonerEdit']['id']) && (int)$this->data['EarningRatePrisonerEdit']['id'] != 0){
                if($this->EarningRatePrisoner->exists($this->data['EarningRatePrisonerEdit']['id'])){
                    $this->data = $this->EarningRatePrisoner->findById($this->data['EarningRatePrisonerEdit']['id']);
                }
            } 
           $gradeslist=$this->EarningRate->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'EarningRate.id',
                        'EarningGrade.name',
                    ),
                     "joins" => array(
                        array(
                            "table" => "earning_grades",
                            "alias" => "EarningGrade",
                            "type" => "LEFT",
                            "conditions" => array(
                            "EarningRate.earning_grade_id = EarningGrade.id"
                            )
                        )),
                    'conditions'    => array(
                        'EarningRate.is_enable'    => 1,
                        'EarningRate.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'EarningGrade.name'
                    )
                ));  
                $prisonerlist=$this->Prisoner->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Prisoner.id',
                        'Prisoner.prisoner_no',
                    ),
                    'conditions'    => array(
                        'Prisoner.is_enable'    => 1,
                        'Prisoner.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'Prisoner.prisoner_no'
                    )
                )); 

              $this->set(compact('gradeslist','prisonerlist'));

     }
     public function assignGradeAjax()
     {
        $this->layout='ajax';
         $condition= array();
         $condition=array('EarningRatePrisoner.is_trash'=> 0);
        $this->paginate=array(
            'recursive'     => 2,
            'conditions' =>$condition,
             'order'     => array(
              'EarningRatePrisoner.modified'=>'DESC' 
              ),
            'limit'     =>20
            );

         $datas=$this->paginate('EarningRatePrisoner');
         $this->set(array(
                'datas' =>$datas,
                
            ));
         //debug($datas);
     }


 }