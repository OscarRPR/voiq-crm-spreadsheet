<?php
App::uses('AppModel', 'Model');
App::uses('Sanitize', 'Utility');
App::uses('Security', 'Utility');
/**
 * User Model
 *
 */
class User extends AppModel {

	public $name = 'User';
	public $displayField = 'username';

	public function beforeValidation($options = array()){
		$this->data['User']['email'] = Sanitize::html($this->data['User']['email']);
		$this->data['User']['username'] = Sanitize::html($this->data['User']['username']);
        $this->data['User']['password'] = Sanitize::html($this->data['User']['password']);
        $this->data['User']['password_confirmation'] = Sanitize::html($this->data['User']['password_confirmation']);
	}
	
	public function beforeDelete($cascade = true) {
		if ($this->data['User']['role'] == 'root'){
			return false;
		}
		return true;
	}

	public function beforeSave($options = array()){
		if($this->data['User']['role'] != 'root'){
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			return true;
		}
	}



/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'between' => array(
				'rule' => array('between', 1, 50),
				'message' => 'The username should be between %d and %d characters',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The username can't be empty.",
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The password can't be empty",
			),
			'between' => array(
				'rule' => array('between', 8, 20),
				'message' => 'The password should be between %d and %d characters.',
			),
			'Match passwords' => array(
				'rule' => 'matchPasswords',
				'message' => 'The passwords are not the same. Please, verify.'
			)
		),
		'password_confirmation' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The password confirmation can't be empty",
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please, enter a valid email address.',
			)
		),
		'role' => array(
			'inlist' => array(
				'rule' => array('inlist', array('Webmaster', 'Agent')),
				'message' => 'The user role should be Webmaster or Agent.',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The user role can't be empty",
			)
		)
	);

	public function matchPasswords($data){
		if($data['password'] == $this->data['User']['password_confirmation']){
			return true;
		}

		$this->invalidate('password_confirmation', "Passwords doesn't match, please try again.");
		return false;
	}
}