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
				'message' => 'El nombre de usuario no puede exeder los 50 caracteres.',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre de usuario no puede ser vacio.',
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La contraseÃ±a no puede ser vacia.',
			),
			'between' => array(
				'rule' => array('between', 8, 20),
				'message' => 'La contraseÃ±a debe tener entre 8 y 20 caracteres.',
			),
			'Match passwords' => array(
				'rule' => 'matchPasswords',
				'message' => 'Las contraseÃ±as no son iguales.'
			)
		),
		'password_confirmation' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'La confirmacion de la contraseÃ±a no puede ser vacia.',
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Por favor ingrese un email valido.',
			)
		),
		'role' => array(
			'inlist' => array(
				'rule' => array('inlist', array('Webmaster', 'Agent')),
				'message' => 'El role del usuario debe ser Analista o Administrador',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El rol del usuario no puede ser vacio.',
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