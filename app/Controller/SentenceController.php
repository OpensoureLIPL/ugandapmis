<?php
App::uses('AppController', 'Controller');
class SentenceController extends AppController {
	public $layout='table';
    public $uses=array('PrisonerSentenceDetail','Prisoner');

	public function index($uuid) {

        if($uuid){

            $prisonList = $this->Prisoner->find('first', array(
                'recursive'     => -1,
                'conditions'    => array(
                    'Prisoner.uuid'     => $uuid,
                ),
            ));
            if(isset($prisonList['Prisoner']['id']) && (int)$prisonList['Prisoner']['id'] != 0)
            {
                $this->set(array(
                    'prisoner_uuid' => $uuid,
                    'prisoner_id' => $prisonList['Prisoner']['id'],
                    'uuid' => $uuid
                ));
            }
            else 
            {
                $this->redirect('/sites/dashboard');
            }
        }
        else 
        {
            $this->redirect('/sites/dashboard');
        }
    }
    public function indexAjax(){ 
        $this->layout = 'ajax';
        $condition = array('PrisonerSentenceDetail.is_trash'	=> 0);
        if(isset($this->data['prisoner_uuid']) && $this->data['prisoner_uuid'] != ''){

            $prisoner_uuid = $this->data['prisoner_uuid'];
            $condition += array('PrisonerSentenceDetail.puuid' => $prisoner_uuid);
        } 
        $this->paginate = array(
            'conditions'    => $condition,
            'order'         =>array(
                'Offence.name'
            ),            
            'limit'         => 20,
        );
        $datas  = $this->paginate('PrisonerSentenceDetail');
        //echo '<pre>'; print_r($condition); exit;
        $this->set(array(
            'datas'             => $datas,
        )); 
    }
}