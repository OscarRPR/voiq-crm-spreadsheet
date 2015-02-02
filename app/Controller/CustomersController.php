<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Helpers', 'ItemTypeFactory');

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class CustomersController extends AppController {

	public $helpers = array('Html', 'Form', 'Session');
	public $components = array('Session');
	
	public function isAuthorized($user){
		if($user['role'] == null){
			return false;
		}
		return true;
	}

	public function getLoadingData() {
		getNumbers();
	}
/**
 * search method
 *
 * @return void
 */
	public function search() {
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Session->delete('SearchConditions');

			if($data['Search']['username'] != '') {
				$this->Session->write('SearchConditions.username', Sanitize::html($data['Search']['username']));
			}
			if($data['Search']['first_name'] != '') {
				$this->Session->write('SearchConditions.first_name', Sanitize::html($data['Search']['first_name']));
			}
			if($data['Search']['last_name'] != '') {
				$this->Session->write('SearchConditions.last_name', Sanitize::html($data['Search']['last_name']));
			}
			$this->redirect(array('action' => 'results'));
		}
	}
	
	private function getConditions() {
		$iConditions = $this->Session->read('SearchConditions');
		if ($iConditions === null) {
			return array();
		}

		if (isset($iConditions['username'])) {
			$conditions['username'] = $iConditions['username'];
		}
		if (isset($iConditions['first_name'])) {
			$conditions['first_name'] = $iConditions['first_name'];
		}
		if (isset($iConditions['last_name'])) {
			$conditions['last_name'] = $iConditions['last_name'];
		}

		return $conditions;
	}
	
	/**
 * search results
 *
 * @return void
 */
	public function results() {
		$conditions = $this->getConditions();

		if(!empty($conditions) and !($conditions === null) and isset($conditions)) {
			$this->paginate = array(
				'conditions' => $conditions, 
				'fields' => array('Customer.id', 'Customer.first_name', 'Customer.last_name', 'Customer.main_email', 'Customer.gender', 'Customer.birthdate', 'User.username'),
				'group'  => array('Customer.id'),
				'order'  => array('Customer.id' => 'asc')
			); 
		} else {
			$this->paginate = array(

				'fields' => array('Customer.id', 'Customer.first_name', 'Customer.last_name', 'Customer.main_email', 'Customer.gender', 'Customer.birthdate', 'User.username'),
				'order'  => array('Customer.id' => 'asc')
			); 
		}	
		$this->Customer->recursive = 0;
		$this->set('customers', $this->paginate());
	}
}