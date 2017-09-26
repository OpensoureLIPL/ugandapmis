<?php
App::uses('AppController', 'Controller');
/**
 * Districts Controller
 *
 * @property District $District
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 * @property SessionComponent $Session
 */
class MenusController extends AppController {
    public $layout='table';
/**
 * Components
 *
 * @var array
 */
	//public $components = array('Paginator', 'Flash', 'Session');
	//public $helpers = array('Html', 'Form');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('Menu');
		$this->Menu->recursive = 0;
		$Parent = $this->Menu->find('list',array(
	         'fields' => 'Menu.name',
	         'conditions' => array(
	         'parent_id' => 0
	         	)
         	)
			);
		// $name = $this->Menu->find('list',array(
	 //         'fields' => 'Menu.name',
	 //         'conditions' => array(
	 //         'Not' => array('parent_id' => 0)
	 //         	)
  //        	)
		// 	);

        // $menuList = $this->Menu->find('all',array(
        //     'recursive'     => -1,
        //     'joins'         => array(
        //         array(
        //             'table'         => 'menus',
        //             'alias'         => 'MainMenu',
        //             'foreignKey'    => false,
        //             'type'          => 'left',
        //             'conditions'    =>array('Menu.parent_id = MainMenu.id')
        //         ),                
        //     ),
        //     'fields'        => array(
        //         'MainMenu.name as parentname',
        //         'Menu.id',
        //         'Menu.name',
        //         'Menu.url',
        //         'Menu.order',
        //         'Menu.is_enable',
        //     ),
        //     'maxLimit'  => 250,
        //     'limit'     => 250,
        // )); //debug($menuList);
		$this->set(array(
            'Parent'         => $Parent,	
            //'name'           => $name,	
        ));
	}
	public function indexAjax(){
		$this->layout = 'ajax';
		$this->loadModel('Menu');
		$parent_id = '';
		$name = '';
		$condition = array();
		$this->Menu->recursive = 0;
    if(isset($this->params['named']['parent_id']) && $this->params['named']['parent_id'] != ''){
        $parent_id = $this->params['named']['parent_id'];
        $condition += array('Menu.parent_id' => $parent_id);
     }
     if(isset($this->params['named']['name']) && $this->params['named']['name'] != ''){
        $name = $this->params['named']['name'];
        $condition += array("Menu.name LIKE '%$name%'");
     }
		$this->paginate = array(
			'conditions' => $condition,
			'recursive'     => -1,
            'joins'         => array(
          array(
              'table'         => 'menus',
              'alias'         => 'MainMenu',
              'foreignKey'    => false,
              'type'          => 'left',
              'conditions'    =>array('Menu.parent_id = MainMenu.id')
          ),                
      ),
      'fields'        => array(
          'MainMenu.name as parentname',
          'Menu.id',
          'Menu.name',
          'Menu.url',
          'Menu.order',
          'Menu.is_enable',
      ),
			'order'=>array(
				'BankBranch.name'=>'asc'
				),
			'limit'=>10,
			);
		$datas = $this->paginate('Menu');
    $this->set(array(
        'datas'          => $datas,
        'parent_id'      => $parent_id,
        'name'           => $name,
    ));
    //debug($condition);
	}
/**
 * add , edit, delete method
 *
 * @return void
 */

	public function addMenu() {
		$this->loadModel('Menu');
		/* for add menu */
        if(isset($this->data['Menu']) && is_array($this->data['Menu']) && count($this->data['Menu'])>0){
            if(isset($this->request->data['Menu']['parent_id']) && $this->request->data['Menu']['parent_id'] == ''){
                $this->request->data['Menu']['parent_id'] = 0;
            }
            if($this->Menu->save($this->request->data)){
                $this->Flash->success(__('The Menu has been saved.'));
				return $this->redirect(array('action' => 'index'));
            }else{
                $this->Flash->error(__('The menu could not be saved. Please, try again.'));
            }            
        }
        /* for edit menu */
        if (isset($this->data['MenuEdit']) && is_array($this->data['MenuEdit']) && count($this->data['MenuEdit'])>0) {
            if($this->Menu->exists($this->data['MenuEdit']['id'])){
                $this->data = $this->Menu->findById($this->data['MenuEdit']['id']);
            }
        }

        /* for delete menu */
        if (isset($this->data['MenuDelete']) && is_array($this->data['MenuDelete']) && count($this->data['MenuDelete'])>0) {
            if($this->Menu->exists($this->data['MenuDelete']['id'])){                
                $this->Menu->delete($this->data['MenuDelete']['id']);
                $this->redirect(array('action'=>'index'));
            }
        }

        $datas = $this->Menu->find('all',array(
            'recursive'     => -1,
            'joins'         => array(
                array(
                    'table'         => 'menus',
                    'alias'         => 'MainMenu',
                    'foreignKey'    => false,
                    'type'          => 'left',
                    'conditions'    =>array('Menu.parent_id = MainMenu.id')
                ),                
            ),
            'fields'        => array(
                'MainMenu.name as parentname',
                'Menu.id',
                'Menu.name',
                'Menu.url',
                'Menu.order',
                'Menu.is_enable',
            ),
        )); 
        $parentList = $this->Menu->find('list', array(
            'recursive'     => -1,
            'conditions'    => array(
                'Menu.parent_id'    => 0,
            ),
            'fields'        => array(
                'Menu.id',
                'Menu.name',
            ),
        )); 
        $this->set(array(
            'title'         => 'Add Menu',
            'datas'         => $datas,
            'parentList'    => $parentList,
        ));

	}
}
