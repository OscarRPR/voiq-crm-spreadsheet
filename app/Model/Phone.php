<?php
App::uses('AppModel', 'Model');
App::uses('Sanitize', 'Utility');
/**
 * PhoneNumber Model
 *
 * @property Customer $Customer
 */
class Phone extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'phones';

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
		$this->data['Customer']['phone_number'] = Sanitize::html($this->data['Customer']['phone_number']);
	}


	/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'phone_number' => array(
			'validateUSPhoneNumbers' => array(
				'rule' => 'validateUSPhoneNumbers',
				'message' => "The phone number format doesn't match a US phone number.",
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "The phone number can't be empty.",
			)
		)
	);

	public function validateUSPhoneNumbers($check) {
		$sPattern = "/^
        (?:                                 # Area Code
            (?:                            
                \(                          # Open Parentheses
                (?=\d{3}\))                 # Lookahead.  Only if we have 3 digits and a closing parentheses
            )?
            (\d{3})                         # 3 Digit area code
            (?:
                (?<=\(\d{3})                # Closing Parentheses.  Lookbehind.
                \)                          # Only if we have an open parentheses and 3 digits
            )?
            [\s.\/-]?                       # Optional Space Delimeter
        )?
        (\d{3})                             # 3 Digits
        [\s\.\/-]?                          # Optional Space Delimeter
        (\d{4})\s?                          # 4 Digits and an Optional following Space
        (?:                                 # Extension
            (?:                             # Lets look for some variation of 'extension'
                (?:
                    (?:e|x|ex|ext)\.?       # First, abbreviations, with an optional following period
                |
                    extension               # Now just the whole word
                )
                \s?                         # Optionsal Following Space
            )
            (?=\d+)                         # This is the Lookahead.  Only accept that previous section IF it's followed by some digits.
            (\d+)                           # Now grab the actual digits (the lookahead doesn't grab them)
        )?                                  # The Extension is Optional
        $/x"; 

        $values = array_values($check);
        $phone = $values[0];
        
        if (preg_match($sPattern, $phone, $matches)) {
        	return true;
        }  

        return false;
	}
}