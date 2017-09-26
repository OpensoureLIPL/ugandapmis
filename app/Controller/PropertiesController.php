<?php
App::uses('AppController', 'Controller');
class PropertiesController   extends AppController {
    public $layout='table';
    public $uses=array('Prisoner', 'Property', 'Propertyitem', 'PropertyDestroy','PropertyOutgoing','PropertyDischarge');
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
                 *Code for add property
                 */
                if(isset($this->data['Property']) && is_array($this->data['Property']) && count($this->data['Property'])>0){
                    if(isset($this->data['Property']['property_date']) && $this->data['Property']['property_date'] != ''){
                        $this->request->data['Property']['property_date'] = date('Y-m-d', strtotime($this->data['Property']['property_date']));
                    }
                    if(isset($this->data['Property']['uuid']) && $this->data['Property']['uuid'] == ''){
                        $uuidArr = $this->Property->query("select uuid() as code");
                        $this->request->data['Property']['uuid'] = $uuidArr[0][0]['code'];                   
                    }
                    $this->request->data['Property']['prisoner_id']     = $prisoner_id;
                    if($this->Property->save($this->data)){
                        $this->Session->write('message_type','success');
                        $this->Session->write('message','Saved Successfully !');
                        $this->redirect(array('controller'=>'properties', 'action'=>'index', $uuid)); 
                    }else{
                        $this->Session->write('message_type','error');
                        $this->Session->write('message','Saving Failed !'); 
                    }
                }
                /*
                 *Code for delete the property
                 */
                if(isset($this->data['PropertyDelete']['id']) && (int)$this->data['PropertyDelete']['id'] != 0){
                    $this->Property->id=$this->data['PropertyDelete']['id'];
                    $this->Property->saveField('is_trash',1);

                    $this->Session->write('message_type','success');
                    $this->Session->write('message','Deleted Successfully !');
                    $this->redirect(array('action'=>'index'));
                }
                /*
                 *Code for edit the property
                 */
                if(isset($this->data['PropertyEdit']['id']) && (int)$this->data['PropertyEdit']['id'] != 0){
                    if($this->Property->exists($this->data['PropertyEdit']['id'])){
                        $this->data = $this->Property->findById($this->data['PropertyEdit']['id']);
                    }
                }
                $propertyitem=$this->Propertyitem->find('list',array(
                    'recursive'     => -1,
                    'fields'        => array(
                        'Propertyitem.id',
                        'Propertyitem.name',
                    ),
                    'conditions'    => array(
                        'Propertyitem.is_enable'    => 1,
                        'Propertyitem.is_trash'     => 0,
                    ),
                    'order'=>array(
                        'Propertyitem.name'
                    )
                )); 
                $statusList = array(
                    'Incoming'         => 'Incoming',
                    'Outgoing'         => 'Outgoing',
                    'Destroy'          => 'Destroy',
                    'FinalDischarge'   => 'Final Discharge',
                );                
                $this->set(array(
                    'prisoner_id'       => $prisoner_id,
                    'propertyitem'      => $propertyitem,
                    'statusList'        => $statusList,
                    'uuid'      =>  $uuid,
                ));
            }else{
                return $this->redirect(array('controller'=>'prisoners', 'action' => 'index')); 
            }
        }else{
            return $this->redirect(array('controller'=>'prisoners', 'action' => 'index')); 
        }
    }
    public function indexAjax(){
        $this->layout           = 'ajax';
        $property_description   = '';
        $propertyitem_id        = '';
        $property_date          = '';
        $source                 = '';
        $uuid                   = '';
        $condition = array(
            'Property.is_trash'                 => 0,
        );
        if(isset($this->params['named']['param']) && $this->params['named']['param'] != ''){
            $param = $this->params['named']['param'];
            if($param == 'Outgoing'){
                $condition += array(
                    'Property.outgoing_status'          => 1,                  
                );
            }else if($param == 'Destroy'){
                $condition += array(
                    'Property.destroid_status'          => 1,                  
                );
            }else if($param == 'FinalDischarge'){
                $condition += array(
                    'Property.final_discharge_status'   => 1,                    
                );
            }else{
                $condition += array(
                    'Property.destroid_status'          => 0,
                    'Property.outgoing_status'          => 0,
                    'Property.final_discharge_status'   => 0,                    
                );
            }
        }
        if(isset($this->params['named']['property_description']) && $this->params['named']['property_description'] != ''){
            $property_description = $this->params['named']['property_description'];
            $condition += array(0=> "Property.property_description LIKE '%$property_description%'");
        } 
        if(isset($this->params['named']['propertyitem_id']) && $this->params['named']['propertyitem_id'] != ''){
            $propertyitem_id = $this->params['named']['propertyitem_id'];
            $condition += array('Property.propertyitem_id' => $propertyitem_id);
        }
        if(isset($this->params['named']['property_date']) && $this->params['named']['property_date'] != ''){
            $property_date = $this->params['named']['property_date'];
            $condition += array('Property.property_date' => date('Y-m-d', strtotime($property_date)));
        } 
        if(isset($this->params['named']['source']) && $this->params['named']['source'] != ''){
            $source = $this->params['named']['source'];
            $condition += array(1=>"Property.propertyitem_id LIKE '%$source%'");
        }  
        if(isset($this->params['named']['uuid']) && $this->params['named']['uuid'] != ''){
            $uuid = $this->params['named']['uuid'];
            
        }               
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Property.modified' => 'DESC',
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('Property');
        $this->set(array(
            'propertyitem_id'           => $propertyitem_id,
            'property_description'      => $property_description,
            'property_date'             => $property_date,
            'source'                    => $source,
            'datas'                     => $datas,
            'param'                     => $param,
            'uuid'                      => $uuid,

        )); 
    }
    public function destroyAjax(){
        $this->autoRender = false;
        $destdata  = '';
        if(isset($this->data['destdata']) && $this->data['destdata'] != '' && isset($this->data['destroy_date']) && $this->data['destroy_date'] != '' && isset($this->data['destroy_cause']) && $this->data['destroy_cause'] != '' && isset($this->data['prisoner_id']) && (int)$this->data['prisoner_id'] != 0){
            $destdata       = $this->data['destdata'];
            $destroy_date   = date('Y-m-d', strtotime($this->data['destroy_date']));
            $destroy_cause  = $this->data['destroy_cause'];
            $prisoner_id    = $this->data['prisoner_id'];
            $arr            = explode(',', $destdata);
            $uuidArr = $this->PropertyDestroy->query("select uuid() as code");
            $dataArr['PropertyDestroy']['uuid']             = $uuidArr[0][0]['code'];    
            $dataArr['PropertyDestroy']['prisoner_id']      = $prisoner_id;         
            $dataArr['PropertyDestroy']['destroy_date']     = $destroy_date;
            $dataArr['PropertyDestroy']['destroy_cause']    = $destroy_cause;
            $dataArr['PropertyDestroy']['property_ids']     = $destdata;
            $dataArr['PropertyDestroy']['user_id']          = $this->Auth->user('id');
            $db = ConnectionManager::getDataSource('default');
            $db->begin();             
            if($this->PropertyDestroy->save($dataArr)){
                $property_destroy_id = $this->PropertyDestroy->id;
                $fields = array(
                    'Property.destroid_status'      => 1,
                    'Property.property_destroy_id'  => $property_destroy_id,
                );
                $conds = array(
                    'Property.id' => $arr
                );                
                if($this->Property->updateAll($fields, $conds)){
                    $db->commit();
                    echo 1;
                }else{
                    $db->rollback();
                    echo 0;
                }
            }else{
                $db->rollback();
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    public function outgoingAjax(){
        $this->autoRender = false;
        $destdata  = '';
        if(isset($this->data['outgoingdata']) && $this->data['outgoingdata'] != '' && isset($this->data['outgoing_date']) && $this->data['outgoing_date'] != '' && isset($this->data['outgoing_cause']) && $this->data['outgoing_cause'] != '' && isset($this->data['outgoing_source']) && $this->data['outgoing_source'] != '' && isset($this->data['prisoner_id']) && (int)$this->data['prisoner_id'] != 0){
            $outgoingdata       = $this->data['outgoingdata'];
            $outgoing_date   = date('Y-m-d', strtotime($this->data['outgoing_date']));
            $outgoing_cause  = $this->data['outgoing_cause'];
            $outgoing_source  = $this->data['outgoing_source'];

            
            $prisoner_id    = $this->data['prisoner_id'];
            $arr            = explode(',', $outgoingdata);
            $uuidArr = $this->PropertyDestroy->query("select uuid() as code");
            $dataArr['PropertyOutgoing']['uuid']             = $uuidArr[0][0]['code'];    
            $dataArr['PropertyOutgoing']['prisoner_id']      = $prisoner_id;         
            $dataArr['PropertyOutgoing']['outgoing_date']     = $outgoing_date;
            $dataArr['PropertyOutgoing']['outgoing_cause']    = $outgoing_cause;
            $dataArr['PropertyOutgoing']['outgoing_source']   = $outgoing_source;
            $dataArr['PropertyOutgoing']['property_ids']     = $outgoingdata;
            $dataArr['PropertyOutgoing']['user_id']          = $this->Auth->user('id');
            $db = ConnectionManager::getDataSource('default');
            $db->begin();             
            if($this->PropertyOutgoing->save($dataArr)){
                $property_outgoing_id = $this->PropertyOutgoing->id;
                $fields = array(
                    'Property.outgoing_status'      => 1,
                    'Property.property_outgoing_id'  => $property_outgoing_id,
                );
                $conds = array(
                    'Property.id' => $arr
                );                
                if($this->Property->updateAll($fields, $conds)){
                    $db->commit();
                    echo 1;
                }else{
                    $db->rollback();
                    echo 0;
                }
            }else{
                $db->rollback();
                echo 0;
            }
        }else{
            echo 0;
        }
    }
    public function finaldischargeAjax(){
        $this->autoRender = false;
        $destdata  = '';
        if(isset($this->data['dischargedata']) && $this->data['dischargedata'] != '' && isset($this->data['discharge_date']) && $this->data['discharge_date'] != '' && isset($this->data['discharge_cause']) && $this->data['discharge_cause'] != '' && isset($this->data['prisoner_id']) && (int)$this->data['prisoner_id'] != 0){
            $dischargedata       = $this->data['dischargedata'];
            $discharge_date   = date('Y-m-d', strtotime($this->data['discharge_date']));
            $discharge_cause  = $this->data['discharge_cause'];
            
            $prisoner_id    = $this->data['prisoner_id'];
            $arr            = explode(',', $dischargedata);
            $uuidArr = $this->PropertyDestroy->query("select uuid() as code");
            $dataArr['PropertyDischarge']['uuid']             = $uuidArr[0][0]['code'];    
            $dataArr['PropertyDischarge']['prisoner_id']      = $prisoner_id;         
            $dataArr['PropertyDischarge']['discharge_date']     = $discharge_date;
            $dataArr['PropertyDischarge']['discharge_cause']    = $discharge_cause;
            $dataArr['PropertyDischarge']['property_ids']     = $dischargedata;
            $dataArr['PropertyDischarge']['user_id']          = $this->Auth->user('id');
            $db = ConnectionManager::getDataSource('default');
            $db->begin();             
            if($this->PropertyDischarge->save($dataArr)){
                $property_discharge_id = $this->PropertyDischarge->id;
                $fields = array(
                    'Property.final_discharge_status'      => 1,
                    'Property.property_discharge_id'  => $property_discharge_id,
                );
                $conds = array(
                    'Property.id' => $arr
                );                
                if($this->Property->updateAll($fields, $conds)){
                    $db->commit();
                    echo 1;
                }else{
                    $db->rollback();
                    echo 0;
                }
            }else{
                $db->rollback();
                echo 0;
            }
        }else{
            echo 0;
        }
    }
}