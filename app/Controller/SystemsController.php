<?php
App::uses('AppController', 'Controller');
/**
 * Systems Controller
 *
 * @property System $System
 * @property PaginatorComponent $Paginator
 */
class SystemsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('System', 'Application');
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index($application_id = null) 
	{
		$this->Application->recursive = -1;
		$application = array();
		if ($application_id == null) {
			$application = $this->Application->find('first', array('fields' => 'id'));
			$application_id = $application['Application']['id'];
		} else {
			$application = $this->Application->findById($application_id);
		}
		
		$this->Application->id = $application_id;
		$this->set('title_for_layout', __('Systems of the %s application', $this->Application->field('name')));
		$this->set('systems', $this->Paginator->paginate(array('System.application_id' => $application_id)));
		$this->set('application_id', $application_id);
		$this->set('application', $application);
	}
	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
		$this->set('system', $this->System->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($application_id) {
		if ($this->request->is('post')) {
			$this->System->create();
			$this->request->data['System']['application_id'] = $application_id;
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved.'));
				return $this->redirect(array('action' => 'index', $application_id));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		}
		$sqlChanges = $this->System->SqlChange->find(
			'list', 
			array(
				'conditions' => array('application_id' => $application_id),
				'fields' => 'id',
				'order' => array('id' => 'desc')
			)
		);
		$this->set(compact('sqlChanges'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->System->exists($id)) {
			throw new NotFoundException(__('Invalid system'));
		}
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->System->save($this->request->data)) {
				$this->Session->setFlash(__('The system has been saved.'));
				$this->System->id = $id;
				return $this->redirect(array('action' => 'index', $this->System->field('application_id')));
			} else {
				$this->Session->setFlash(__('The system could not be saved. Please, try again.'));
			}
		}
		
		$options = array('conditions' => array('System.' . $this->System->primaryKey => $id));
		$this->request->data = $this->System->find('first', $options);
		
		$sqlChanges = $this->System->SqlChange->find(
			'list', 
			array(
				'conditions' => array('application_id' => $this->request->data['System']['application_id']),
				'fields' => 'id',
				'order' => array('id' => 'desc')
			)
		);
		$this->set(compact('sqlChanges'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->System->id = $id;
		if (!$this->System->exists()) {
			throw new NotFoundException(__('Invalid system'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->System->delete()) {
			$this->Session->setFlash(__('The system has been deleted.'));
		} else {
			$this->Session->setFlash(__('The system could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
