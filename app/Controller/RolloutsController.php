<?php
App::uses('AppController', 'Controller');
/**
 * Rollouts Controller
 *
 * @property Rollout $Rollout
 * @property PaginatorComponent $Paginator
 */
class RolloutsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Rollout', 'SqlChange', 'System');
/**
 * index method
 *
 * @return void
 */
	public function index($system_id) 
	{
		$this->Rollout->recursive = 0;
		$this->Paginator->settings = array('order' => array('Rollout.id' => 'DESC'));
		$this->set('rollouts', $this->Paginator->paginate(array('Rollout.system_id' => $system_id)));
		
		$this->System->recursive = -1;
		$this->System->Behaviors->load('Containable');
		$system = $this->System->find(
			'first', 
			array(
				'conditions' => array('System.id' => $system_id),
				'contain' => array(
					'Application'
				),
				'fields' => array('System.id', 'System.name', 'System.sql_change_id', 'System.application_id', 'Application.id', 'Application.name')
			)
		);
		$this->set(compact('system'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($system_id) {
		if ($this->request->is('post')) {
			$this->Rollout->create();
			$this->request->data['Rollout']['system_id'] = $system_id;
			
			if ($this->request->data['Rollout']['rolled_out']) {
				$this->Rollout->System->id = $system_id;
				$this->Rollout->System->recursive = -1;
				$system = $this->Rollout->System->read(array('id', 'sql_change_id'));
				$system['System']['sql_change_id'] = $this->request->data['Rollout']['end_change_id'];
				if (!$this->Rollout->System->save($system)) {
					$this->Session->setFlash(__('Unable to bump the sql change revision of the system!'));
					return;
				}
			}
			if ($this->Rollout->save($this->request->data)) {
				$this->Session->setFlash(__('The rollout has been saved.'));
				return $this->redirect(array('action' => 'index', $system_id));
			} else {
				$this->Session->setFlash(__('The rollout could not be saved. Please, try again.'));
			}
		}
		
		$this->System->id = $system_id;
		$system = $this->System->read();
		
		$changeFindOptions = array(
			'fields' => 'id', 
			'conditions' => array(
				'application_id' => $system['System']['application_id'],
				'id > ' => $system['System']['sql_change_id']
			)
		);
		
		$startChanges = $this->Rollout->StartChange->find('list', $changeFindOptions);
		$endChanges = $this->Rollout->EndChange->find('list', $changeFindOptions);
		
		if (empty($startChanges)) {
			$this->Session->setFlash(__('All changes are rolled out!'));
			$this->redirect(array('action' => 'index', $system_id));
		}
		
		$this->set(compact('systems', 'startChanges', 'endChanges', 'system'));
	}

	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Rollout->exists($id)) {
			throw new NotFoundException(__('Invalid rollout'));
		}
		$this->Rollout->id = $id;
		$rollOut = $this->Rollout->read();
		
		if ($this->request->is(array('post', 'put'))) {
			if ($this->request->data['Rollout']['end_change_id'] > $rollOut['System']['sql_change_id']) {
				$rollOut['System']['sql_change_id'] = $this->request->data['Rollout']['end_change_id'];
				if ($this->Rollout->System->save($rollOut['System'])) {
					$this->Session->setFlash(__('Unable to update the system\'s last sql change id'));
				}
			}
			
			if ($this->Rollout->save($this->request->data)) {
				$this->Session->setFlash(__('The rollout has been saved.'));
				$this->Rollout->id = $id;
				return $this->redirect(array('action' => 'index', $this->Rollout->field('system_id')));
			} else {
				$this->Session->setFlash(__('The rollout could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rollout.' . $this->Rollout->primaryKey => $id));
			$this->request->data = $this->Rollout->find('first', $options);
		}
		$systems = $this->Rollout->System->find('list');
		
		$this->System->id = $rollOut['Rollout']['system_id'];
		$system = $this->System->read();
		
		$changeFindOptions = array(
			'fields' => 'id', 
			'conditions' => array(
				'application_id' => $system['System']['application_id'],
			)
		);
		
		$startChanges = $this->Rollout->StartChange->find('list', $changeFindOptions);
		$endChanges = $this->Rollout->EndChange->find('list', $changeFindOptions);
		$this->set(compact('systems', 'startChanges', 'endChanges', 'rollOut'));
	}

	public function apply($id = null) {
		$this->Rollout->id = $id;
		if (!$this->Rollout->exists()) {
			throw new NotFoundException(__('Invalid rollout'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function rolled_out($id = null) {
		$this->Rollout->id = $id;
		
		$this->Rollout->recursive = -1;
		$rollout = $this->Rollout->read(array('system_id', 'end_change_id'));
		$this->request->onlyAllow('post', 'delete');
		
		$success = $this->Rollout->updateAll(
			array(
				'rolled_out' => 1
			),
			array(
				'Rollout.id <=' => $id
			)
		);
		
		$this->System->recursive = -1;
		$this->System->id = $rollout['Rollout']['system_id'];
		$system = $this->System->read(array('sql_change_id', 'id'));
		if ($system['System']['sql_change_id'] < $rollout['Rollout']['end_change_id']) {
			$this->System->set('sql_change_id', $rollout['Rollout']['end_change_id']);
			$this->System->save();
		}
		
		if ($success) {
			$this->Session->setFlash(__('The rollout marked as completed!'));
		} else {
			$this->Session->setFlash(__('Unable to mark the rollout completed'));
		}
		return $this->redirect(array('action' => 'index', $rollout['Rollout']['system_id']));
	}
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Rollout->id = $id;
		if (!$this->Rollout->exists()) {
			throw new NotFoundException(__('Invalid rollout'));
		}
		$system_id = $this->Rollout->field('system_id');
		$this->request->onlyAllow('post', 'delete');
		if ($this->Rollout->delete()) {
			$this->Session->setFlash(__('The rollout has been deleted.'));
		} else {
			$this->Session->setFlash(__('The rollout could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index', $system_id));
	}
	
	public function sql($rollout_id)
	{
		$this->Rollout->recursive = -1;
		$this->Rollout->Behaviors->load('Containable');
		$rollout = $this->Rollout->find(
			'first', 
			array(
				'contain' => array('System'),
				'fields' => array(
					'Rollout.id', 'Rollout.system_id', 'System.id', 'System.application_id', 'Rollout.start_change_id', 'Rollout.end_change_id'
				),
				'conditions' => array('Rollout.id' => $rollout_id)
			)
		);
		
		if (!isset($rollout['Rollout'])) {
			throw new NotFoundException(__('Invalid rollout'));
		}
			
		$changes = $this->SqlChange->find(
			'list',
			array(
				'fields' => array('change'),
				'conditions' => array(
					'application_id' => $rollout['System']['application_id'],
					'id >=' => $rollout['Rollout']['start_change_id'],
					'id <=' => $rollout['Rollout']['end_change_id']
				)
			)
		);
		
		foreach ($changes as $id => $change) {
			$change = trim($change);
			if (mb_substr($change, -1) !== ';')
				$change .= ';';
			echo nl2br($change).' -- '.$id.'<br><br>';
		}
		$this->layout = 'blank';
	}
	
	public function php_sql($rollout_id) 
	{
		$this->Rollout->recursive = -1;
		$this->Rollout->Behaviors->load('Containable');
		$rollout = $this->Rollout->find(
			'first', 
			array(
				'contain' => array('System'),
				'fields' => array(
					'Rollout.id', 'Rollout.system_id', 'System.id', 'System.application_id', 'Rollout.start_change_id', 'Rollout.end_change_id'
				),
				'conditions' => array('Rollout.id' => $rollout_id)
			)
		);
		
		if (!isset($rollout['Rollout'])) {
			throw new NotFoundException(__('Invalid rollout'));
		}
			
		$data = '<?php
	$servername = "localhost";
	$username = "username";
	$password = "password";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error. "<br><br>");
	}
	echo "Connected successfully<br><br>";';
		
		$changes = $this->SqlChange->find(
			'list',
			array(
				'fields' => array('change'),
				'conditions' => array(
					'application_id' => $rollout['System']['application_id'],
					'id >=' => $rollout['Rollout']['start_change_id'],
					'id <=' => $rollout['Rollout']['end_change_id']
				)
			)
		);
		
		
		foreach ($changes as $id => $change) {
			$data .= '
	$sql = "'.$change.'";
	if ($conn->query($sql) === TRUE) {
		echo "Query #'.$id.' => OK<br>";
	} else {
		die("Error during SQL query: ".$sql. ": " . $conn->error."<br>");
	}
	';
		}

		$data .= '$conn->close();?>';
		
		$this->response->body($data);
		$this->response->type('text/plain');

		//Optionally force file download
		$this->response->download('upgrade_sql.php');

		// Return response object to prevent controller from trying to render
		// a view
		return $this->response;
	}
}
