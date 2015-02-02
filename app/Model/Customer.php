<?php
App::uses('AppModel', 'Model');
App::uses('Sanitize', 'Utility');
/**
 * Customer Model
 *
 * @property Customer $Customer
 */
class Customer extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'customers';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array (
	    'Phone'   =>  array(
	        'className'     =>  'Phone'
	    ), 
	    'Email'   =>  array(
	        'className'     =>  'Email'
	    ), 
	);

	public function beforeValidation($options = array()){
		$this->data['Customer']['first_name'] = Sanitize::html($this->data['Customer']['first_name']);
		$this->data['Customer']['last_name'] = Sanitize::html($this->data['Customer']['last_name']);
		$this->data['Customer']['gender'] = Sanitize::html($this->data['Customer']['gender']);
		$this->data['Customer']['birthdate'] = Sanitize::html($this->data['Customer']['birthdate']);
	}

	public function beforeSave($options = array()) {
		if (preg_match('/^(\d{2})\-(\d{2})\-(\d{4})$/', $this->data['Customer']['birthdate'], $matches)) {
			$dateStr = $matches[3]."-".$matches[1]."-".$matches[2];
			$this->data['Customer']['birthdate'] = $dateStr;
		}
	}

	/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'between' => array(
				'rule' => array('between', 1, 80),
				'message' => 'The first name should be between %d and %d characters.',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The first name can't be empty",
			),
		),
		'last_name' => array(
			'between' => array(
				'rule' => array('between', 1, 80),
				'message' => 'The last name should be between %d and %d characters.',
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The last name can't be empty.",
			),
		),
		'gender' => array(
			'inlist' => array(
				'rule' => array('inlist', array('Male', 'Female', '')),
				'message' => 'The gender must be Male, Female (case sensitive) or empty.',
			)
		),
		'birthdate' => array(
            'rule' => 'validateBirthday',
            'message' => 'Wrong format of birthdate.',
            'allowEmpty' => true,
        ),
		'main_email' => array(
			'validateEmail' => array(
				'rule' => 'validateEmail',
				'message' => 'The main email is not valid.',
				'allowEmpty' => true,
			)
		),
		
	);

	public function validateBirthday($check) {
		$value = array_values($check);
	    $value = $value[0];

	    if (preg_match('/^(\d{2})\-(\d{2})\-(\d{4})$/', $value, $matches)) {
	        return checkdate($matches[1], $matches[2], $matches[3]);
	    } else {
	        return false;
    	}
	}

	public function validateEmail($data) {
		$value = array_values($data);
	    $value = $value[0];

		if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
			return true;
		}

		return false;
	}
}