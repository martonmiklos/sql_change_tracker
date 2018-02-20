<?php
App::uses('AppController', 'Controller');
/**
 * SqlChanges Controller
 *
 * @property SqlChange $SqlChange
 * @property PaginatorComponent $Paginator
 */
class SqlChangesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $uses = array('SqlChange', 'Application', 'Rollout', 'System');
	public $components = array('Paginator', 'RequestHandler');
	public $paginate = array(
        'order' => array(
            'SqlChange.id' => 'desc'
        )
    );
/**
 * index method
 *
 * @return void
 */
 
	public function by_rollout($rollout_id)
	{
		$this->SqlChange->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		
		$this->set('application_id', $application_id);

		
		$this->set('title_for_layout', __('SQL changes contained in the #%s rollout', $rollout_id));
		//$this->set('sqlChanges', $this->Paginator->paginate(array('application_id' => $application_id, 'AND' => array('SqlChange.id BETWEEN ? AND ?' => array($rollOut,10))))));
		// TODO
		$this->set('application_id', 0);
		$this->render('index');
	}
 
	public function index($application_id = null) {
		$this->SqlChange->recursive = 0;
		$this->Paginator->settings = $this->paginate;
		$this->set('application_id', $application_id);
		
		if ($application_id == null) {
			$applicationData = $this->Application->find('first', array('fields' => 'id'));
			$application_id = $applicationData['Application']['id'];
		}
		
		$this->set('applications', $this->Application->find('list'));
		$this->Application->id = $application_id;
		$this->set('title_for_layout', __('SQL changes for: %s', $this->Application->field('name')));
		$this->set('sqlChanges', $this->Paginator->paginate(array('application_id' => $application_id)));
		$this->set('application_id', $application_id);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SqlChange->exists($id)) {
			throw new NotFoundException(__('Invalid sql change'));
		}
		$options = array('conditions' => array('SqlChange.' . $this->SqlChange->primaryKey => $id));
		$this->set('sqlChange', $this->SqlChange->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($application_id) {
		if ($this->request->is('post')) {
			$this->SqlChange->create();
			$this->request->data['SqlChange']['change'] = trim($this->request->data['SqlChange']['change']);
			if (mb_substr($this->request->data['SqlChange']['change'], -1) !== ';')
				$this->request->data['SqlChange']['change'] = $this->request->data['SqlChange']['change'] . ';';
			$this->request->data['SqlChange']['application_id'] = $application_id;
			if ($this->SqlChange->save($this->request->data)) {
				$this->SqlChange->Application->id = $application_id;
				$applicationData = $this->SqlChange->Application->read(array('revision_file_path'));
				if ($this->updateRevisionFile($applicationData['Application']['revision_file_path'], $this->SqlChange->id)) 
					$this->Session->setFlash(__('The sql change has been saved.'));
				else 
					$this->Session->setFlash(__('The sql change has been saved, but unable to update revision file.'));
				return $this->redirect(array('action' => 'index', $application_id));
			} else {
				$this->Session->setFlash(__('The sql change could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SqlChange->exists($id)) {
			throw new NotFoundException(__('Invalid sql change'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SqlChange->save($this->request->data)) {
				$this->SqlChange->id = $id;
				$this->Session->setFlash(__('The sql change has been saved.'));
				return $this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The sql change could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SqlChange.' . $this->SqlChange->primaryKey => $id));
			$this->request->data = $this->SqlChange->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SqlChange->id = $id;
		$this->SqlChange->recursive = -1;
		$sqlChange = $this->SqlChange->read();
		if (!isset($sqlChange['SqlChange'])) {
			throw new NotFoundException(__('Invalid sql change'));
		}
	
		$this->System->recursive = -1;
		$systems = $this->System->findAllBySqlChangeId($id, array('id', 'sql_change_id'));
		if (count($systems)) {
			// find the next sqlchange 
			$nextChange = $this->SqlChange->find(
				'first', 
				array(
					'conditions' => array(
						'application_id' => $sqlChange['SqlChange']['application_id'], 
						'id NOT' => $sqlChange['SqlChange']['id']
					), 
					'order' => array('SqlChange.id' => 'DESC'),
					'fields' => array('id')
				)
			);
			
			foreach ($systems as &$system) {
				$system['System']['sql_change_id'] = $nextChange['SqlChange']['id'];
			}
			
			if (!$this->System->saveMany($systems)) {
				throw new NotFoundException(__('Invalid sql change'));
			}		
		}
		
		$application_id = $this->SqlChange->field('application_id');
		$this->request->onlyAllow('post', 'delete');
		if ($this->SqlChange->delete()) {
			$this->Session->setFlash(__('The sql change has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sql change could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index', $application_id));
	}
	
	private function updateRevisionFile($filePath, $revision)
	{
		if ($filePath != '' && file_exists($filePath)) {
			$jsonData = json_decode(file_get_contents($filePath), true);
			$jsonData['sqlRevision'] = $revision;
			$jsonData = json_encode($jsonData, JSON_PRETTY_PRINT);
			if (file_put_contents($filePath, $jsonData)) {
				return true;
			}
		} 
		return false;
	}
	
	public function add_sql_change() 
	{
		$result = 'fail';
		if ($this->request->is('post')) {
			$this->SqlChange->Application->recursive = -1;
			$applicationData = $this->SqlChange->Application->findByMasterDatabase(
				$this->request->data['SqlChange']['masterDatabase'], 
				array("id", "revision_file_path")
			);
			
			if (isset($applicationData['Application']['id'])) {
				if (mb_substr($this->request->data['SqlChange']['sql'], -1) !== ';')
					$this->request->data['SqlChange']['sql'] = $this->request->data['SqlChange']['sql'] . ';';
				$sqlChangeData = array(
					'application_id' => $applicationData['Application']['id'],
					'change' => $this->request->data['SqlChange']['sql']
				);
				$this->SqlChange->create();
				if ($this->SqlChange->save($sqlChangeData)) {
					$result = 'ok';
				}
				
				if (!$this->updateRevisionFile($applicationData['Application']['revision_file_path'], $this->SqlChange->id)) {
					$result = __('Unable to update the revision file (%s)', $applicationData['Application']['revision_file_path']);
				}
			}
		}
		$this->set('result', $result);
	}
	
	public function search($application_id)
	{
		if ($this->request->is('post')) {
			$this->SqlChange->recursive = 0;
			$this->Paginator->settings = $this->paginate;
			$this->set('application_id', $application_id);
			
			if ($application_id == null) {
				$applicationData = $this->Application->find('first', array('fields' => 'id'));
				$application_id = $applicationData['Application']['id'];
			}
			
			$this->set('applications', $this->Application->find('list'));
			$this->Application->id = $application_id;
			$this->set('title_for_layout', __('SQL changes for: %s containing phrase: %s', $this->Application->field('name'), $this->request->data['Search']['term']));
			$this->set('sqlChanges', $this->Paginator->paginate(
				array(
					'application_id' => $application_id, 
					'OR' => array(
						'comment LIKE' => '%'.$this->request->data['Search']['term'].'%',
						'change LIKE' => '%'.$this->request->data['Search']['term'].'%',
					)
				)
			));
			$this->render('index');
		}
		$this->set('application_id', $application_id);
	}
}
