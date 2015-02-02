<?php

	App::uses('Customer', 'Model');
	App::uses('Phone', 'Model');
	App::uses('Email', 'Model');

	require_once("../../app/Controller/FileStrategy/IFileHandler.php");

	abstract class BaseFileHandler implements IFileHandler {

		protected $type;
		protected $startTime;
		protected $endTime;
		protected $headers = array(HEADER_FIRST_NAME_STR, 
					  			HEADER_LAST_NAME_STR, 
					  			HEADER_PHONE_NUMBERS_STR, 
					  			HEADER_MAIN_EMAIL_STR, 
					  			HEADER_EXTRA_EMAILS_STR, 
					  			HEADER_GENDER_STR, 
					  			HEADER_BIRTHDATE_STR);

		public function getType() {
			return $this->type;
		}

	    abstract public function process($filename, $userId);

	    public function validateData($data, $userId, &$arrayCustomers, &$arrayErrors, $idxRow) {
	    	$numberErrors = 0;
	    	$errorStr = "";

	    	$firstName = $data[HEADER_FIRST_NAME_IDX];
			$lastName = $data[HEADER_LAST_NAME_IDX];
			$phoneNumbers = $data[HEADER_PHONE_NUMBERS_IDX];
			$mainEmail = $data[HEADER_MAIN_EMAIL_IDX];
			$extraEmails = $data[HEADER_EXTRA_EMAILS_IDX];
			$gender = $data[HEADER_GENDER_IDX];
			$birthdate = $data[HEADER_BIRTHDATE_IDX];

			if (!array_filter($data)) {
				return null;
			}

			$mainEmail = preg_replace('/\s+/', '', $mainEmail);
			$birthdate = preg_replace('/\s+/', '', $birthdate);

			$newCustomer = array(HEADER_FIRST_NAME_STR => $firstName, 
				HEADER_LAST_NAME_STR => $lastName, 
				HEADER_GENDER_STR => $gender, 
				HEADER_BIRTHDATE_STR => $birthdate,
				HEADER_MAIN_EMAIL_STR => $mainEmail,
				USER_ID => $userId);
			
			$errorsPhones = 0;
			$phoneNumbers = preg_replace('/\s+/', '', $phoneNumbers);
			$phonesExplode = explode("|", $phoneNumbers);
			$phones = array();
			$phonesValidated = true;

			if (count($phonesExplode) > 0) {
				foreach($phonesExplode as $phoneNumber) {
					$phone = array(PHONE_NUMBER_STR => $phoneNumber);
					$phones[] = $phone;

					$phoneModel = new Phone($phone);
					$phoneModel->set($phone);
					if (!$phoneModel->validates()) {
						$errorStr .= $this->getArrayErrors($phoneModel->validationErrors);
						$phonesValidated = false;
						$errorsPhones += count($phoneModel->validationErrors);
					}
				}
			} else {
				$errorsPhones += 1;
			}

			$extraEmails = preg_replace('/\s+/', '', $extraEmails);
			$emailsExplode = explode("|", $extraEmails);
			$emails = array();

			$emailsValidated = true;
			$emailsModels = array();
			$errorsEmails = 0;

			if (count($emailsExplode) > 0) {
				foreach($emailsExplode as $email) {
					if (!empty($email)) {
						$emailData = array(EMAIL_STR => $email);
						$emails[] = $emailData;

						$emailModel = new Email();
						$emailModel->set($emailData);
						if (!$emailModel->validates()) {
							$errorStr .= $this->getArrayErrors($emailModel->validationErrors);
							$emailsValidated = false;
							$errorsEmails += count($emailModel->validationErrors);
						}
					}
				}
			} 

			$customer = new Customer();
			$customer->set($newCustomer);

			$dataRow = array(CUSTOMER_CLASS => $newCustomer,
					   		 PHONE_CLASS => $phones,
					   		 EMAIL_CLASS => $emails);

			if ($customer->validates() && $phonesValidated && $emailsValidated) {
				$arrayCustomers[] = $dataRow;
			} else {
				$errorStr = $this->getArrayErrors($customer->validationErrors).$errorStr;
				$numberErrors += count($customer->validationErrors) + $errorsEmails + $errorsPhones;
				$arrayErrors[$idxRow] = $errorStr;
			}

			return $numberErrors;
	    }

	    public function upload($arrayCustomers, $numberErrors, $arrayErrors, $lastRow) {
	    	if ($numberErrors <= 0) {
				$customerSave = new Customer();
				foreach($arrayCustomers as $dataRow) {
					$customerSave->saveAssociated($dataRow, array('deep' => true, 'atomic' => true));
					addProgress();
				}
			} 

			updateProgress($lastRow*2);

			$this->endTime = time();
			$totalTime = $this->endTime - $this->startTime;

			$arrayUploadInformation = array($numberErrors, date('m-d-Y'), $totalTime, $arrayErrors);
			return $arrayUploadInformation;
	    }

	    public function checkHeaders($inputHeaders) {
	    	for ($i = 0; $i < count($this->headers) && $i < count($inputHeaders); $i++) {
				$originalHeader = trim($this->headers[$i]);
				$inputHeader = trim($inputHeaders[$i]);

				if ($originalHeader != $inputHeader) {
					return "The file header doesn't match. Please, verify the file and check if they match with the specification.";
				}
			}
			return null;
	    }

	    public function getArrayErrors($arrayErrors) {
	    	$errorStr = "";
	    	foreach($arrayErrors as $error) {
	    		$errorStr .= $error[0]." ";
	    		
	    	}
	    	return $errorStr;
	    }
	}

?>