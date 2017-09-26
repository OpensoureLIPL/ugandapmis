<?php
App::uses('Controller', 'Controller');

class StationjournalsController extends AppController{
		public $layout='table';
    	public $uses=array('Stationjournal','Prison');
     /**
     * Index Function
     */
    public function index() {
       $prison_id=$this->Prison->find('list',array(
                'conditions'=>array(
                  'Prison.is_enable'=>1,
                  'Prison.is_trash'=>0,
                ),
                'order'=>array(
                  'Prison.name'
                )
          ));
       $this->set(compact('prison_id'));
    }
    public function indexAjax(){
        $this->layout   = 'ajax';
        $prison_id      = '';
        $journal_date      = '';
        $condition      = array(
            'Stationjournal.is_trash'         => 0,
        );
        if(isset($this->params['named']['prison_id']) && $this->params['named']['prison_id'] != ''){
            $prison_id = $this->params['named']['prison_id'];
            $condition += array('Stationjournal.prison_id' => $prison_id );
        }
        if(isset($this->params['named']['journal_date']) && $this->params['named']['journal_date'] != ''){
            $journal_date = $this->params['named']['journal_date'];
            $journal_date=date('Y-m-d',strtotime($journal_date));
            $condition += array('Stationjournal.journal_date' => $journal_date );
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
                'Stationjournal.modified',
            ),
            'limit'         => 20,
        );
        $datas = $this->paginate('Stationjournal');
        $this->set(array(
            'datas'         => $datas,
            'journal_date'     => $journal_date,   
            'prison_id'     => $prison_id,      
        ));
    }
    /**
     * Add Function
     */
    public function add(){
        $this->layout='table';
        if($this->request->is(array('post','put'))){
            $this->request->data['Stationjournal']['journal_date']=date('Y-m-d',strtotime($this->request->data['Stationjournal']['journal_date']));
            if($this->Stationjournal->save($this->request->data)){
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
        $prison_id=$this->Prison->find('list',array(
                'conditions'=>array(
                  'Prison.is_enable'=>1,
                  'Prison.is_trash'=>0,
                ),
                'order'=>array(
                  'Prison.name'
                )
          ));
          
        $this->set(compact('is_enable','prison_id'));
    }
    /**
     * Edit Function
     */
    public function edit($id){
        $this->layout='table';
        if($this->request->is(array('post','put'))){
             $this->request->data['Stationjournal']['journal_date']=date('Y-m-d',strtotime($this->request->data['Stationjournal']['journal_date']));
            if($this->Stationjournal->save($this->request->data)){
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
        $prison_id=$this->Prison->find('list',array(
                'conditions'=>array(
                  'Prison.is_enable'=>1,
                  'Prison.is_trash'=>0,
                ),
                'order'=>array(
                  'Prison.name'
                )
          ));
        $this->set(compact('is_enable','prison_id'));
        $this->request->data=$this->Stationjournal->findById($id);
    }
    /**
     * Delete Function
     */
    public function delete($id){
        $this->Stationjournal->delete($id);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Deleted Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////
    public function disable($id){
        $this->Stationjournal->id=$id;
        $this->Stationjournal->saveField('is_enable',0);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Disabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    /////////////////////////
    public function enable($id){
        $this->Stationjournal->id=$id;
        $this->Stationjournal->saveField('is_enable',1);
        $this->Session->write('message_type','success');
        $this->Session->write('message','Enabled Successfully !');
        $this->redirect(array('action'=>'index'));
    }
    public function trash($id){
      $this->Stationjournal->id=$id;
      $this->Stationjournal->updateAll(
            array('Stationjournal.is_trash' => 1),
            array('Stationjournal.id' => $id)
        );
      //$this->Document->saveField('is_trash',1);
      $this->Session->write("message_type",'success');
      $this->Session->write('message','Trashed Successfully !');
      $this->redirect(array(
        'controller'=>'stationjournals',
        'action'=>'index'
      ));
    }
    public function getStationName($id){
        $prisonDetail=$this->Prison->find('first',array(
                'conditions'=>array(
                  'Prison.id'=>$id,
                ),
                
        ));
        return $prisonDetail["Prison"]["name"];
    }
}
?>