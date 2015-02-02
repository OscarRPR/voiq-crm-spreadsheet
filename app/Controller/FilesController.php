<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::import('Helpers', 'ItemTypeFactory');

require_once("FileStrategy/StrategySelector.php");
require_once("../../app/View/Utils/loadBar.php");

/**
 * Customers Controller
 *
 * @property Customer $Customer
 */
class FilesController extends AppController {

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

	public function upload() {

		resetNumbers();

		if ($this->request->is('post')) {
			set_time_limit(600);
			ini_set('memory_limit', '128M');

		    if(isset($this->request->data['FileInput'])) {
		        $file = $this->request->data['FileInput'];

		        if ($file['size'] > 0) {
			        $targetPath = APP . 'tmp' . DS . 'files' . DS .'crm' . $file['name'];
			        if ($file['error'] === UPLOAD_ERR_OK && move_uploaded_file($file['tmp_name'], $targetPath)) {
			        	$extension = pathinfo($targetPath, PATHINFO_EXTENSION);
			        	$extension = strtoupper($extension);

			        	chmod($targetPath, 0755);

			        	$strategySelector = new StrategySelector();
			        	$isAvailable = $strategySelector->isFormatAvailable($extension);
			        	$strategy = $strategySelector->getHandler($extension);

			        	$userId = $this->request->data['id'];
			        	if ($isAvailable && isset($strategy)) {	
			        		session_write_close();
			        		$arrayResponse = $strategy->process($targetPath, $userId);

			        		if (is_array($arrayResponse)) {
			        			$nameUser = $this->request->data['username'];
			        			$errors = $arrayResponse[0];
			        			$date = $arrayResponse[1];
			        			$time = $arrayResponse[2];
			        			$log = $arrayResponse[3];
			        			$time = $this->timeElapsed($time);

			        			$message = "Time Uploading: ".$time."\r\n".
			        					   "Errors: ".$errors."\r\n".
			        					   "Date: ".$date."\r\n".
			        					   "User: ".$nameUser."\r\n";
								
			        			$this->Session->delete('Message.flash');		   
								$this->createLog($message, $log);

							    $this->response->file('tmp' . DS . 'files' . DS .'logErrors.txt', array('download' => true, 'name' => 'logErrors.txt'));
							    return $this->response;
			        		} else {
			        			$this->Session->setFlash(__($arrayResponse));
			        		}

			        	} else {
			        		$this->Session->setFlash(__("The format of the file it's not available to process. Try any of the formats of the formats available."));
			        	}
			        }
		        } else {
					$this->Session->setFlash(__("You should choose a file to upload."));
				}
    		} 
		}
	}

	public function createLog($message, $errorLog) {
		$handle = fopen(APP . 'tmp' . DS . 'files' . DS .'logErrors.txt', "w");

		fwrite($handle, $message);

		foreach($errorLog as $row => $error) {
			$errorString = "Row: ".$row." Errors: ".$error."\r\n";
			fwrite($handle, $errorString);
		}	
		fclose($handle);
	}

	private function timeElapsed($secs){
	    $bit = array(
	        'y' => $secs / 31556926 % 12,
	        'w' => $secs / 604800 % 52,
	        'd' => $secs / 86400 % 7,
	        'h' => $secs / 3600 % 24,
	        'm' => $secs / 60 % 60,
	        's' => $secs % 60
	        );
	        
	    $ret = array();
	    foreach($bit as $k => $v) {
	        if($v > 0) {
	        	$ret[] = $v . $k;
	    	}
	    }

	    if (empty($ret)) {
	    	$ret[0] = "0"."s";
	    }
	        
	    return join(' ', $ret);
    }
}