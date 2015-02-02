<?php
App::uses('AppModel', 'Model');
App::uses('Sanitize', 'Utility');
/**
 * PhoneNumber Model
 *
 * @property Customer $Customer
 */
class Email extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'emails';

	public $belongsTo = array(
		'Customer' => array(
			'className' => 'Customer',
			'foreignKey' => 'customer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeValidation($options = array()){
		$this->data['Customer']['email'] = Sanitize::html($this->data['Customer']['email']);
	}

	/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'validateEmail' => array(
				'rule' => 'validateEmail',
				'message' => 'The email is not valid.',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "Email can't be empty.",
			),
		)
	);

	public function validateEmail($data) {
		$value = array_values($data);
	    $value = $value[0];
	    
		if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return true;
		}

		return false;
	}
}