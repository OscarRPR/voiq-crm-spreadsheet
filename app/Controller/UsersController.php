<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
	public function isAuthorized($user) {	
		if(in_array($this->action, array('login', 'logout'))){
			return true;
		}
		if($this->action == 'edit'){
			if($user['id'] == $this->request->params['pass'][0]) {
				return true;
			}
			return false;
		}

		if($user['role'] == 'Agent'){
			if($this->action == 'view') {
				if($user['id'] == $this->request->params['pass'][0]) {
					return true;	
				}	
				return false;
			}
			return false;
		}
		return true;
	}

	public function login() {
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
      	 	} else {
      	 		$this->Session->setFlash(__("The username and password doesn't match, please try again."));
        	}	
    	}
	}
	
	public function logout() {
    	$this->redirect($this->Auth->logout());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Not valid Id.'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        if ($this->request->is('post')) {
			try{
				$this->User->create();
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The new user was correctly saved.'));
                	$this->redirect(array('action' => 'index'));
            	} else {
            		$this->Session->setFlash(__("The new user wasn't saved. Please, try again."));
           		}
           	} catch(PDOException $e) {
				if(strpos($e->getMessage(),'Duplicate') !== false){
					$this->Session->setFlash(__('The username is already taken. Please, try with a different username.'));
				} else {
					throw $e;
				}
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
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid Id.'));
		}
		$oldUser = $this->User->findById($id);
		$this->request->data['User']['role'] = $oldUser['User']['role'];
		if ($this->request->is('post') || $this->request->is('put')) {
			try{
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('The user information was updated correctly.'));
					$this->redirect(array('action' => 'view',$id));
				} else {
					$this->Session->setFlash(__("The user information wasn't updated correctly. Please, try again."));
				}
			} catch(PDOException $e){
				if(strpos($e->getMessage(),'Duplicate') !== false){
					$this->Session->setFlash(__('The username is already taken. Please, try with a different username.'));
				} else {
					throw $e;
				}
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid Id'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('The user was deleted correctly.'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__("The user wasn't deleted. Please, try again."));
		$this->redirect(array('action' => 'index'));
	}
}