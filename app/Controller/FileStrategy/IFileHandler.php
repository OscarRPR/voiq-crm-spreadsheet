<?php

	interface IFileHandler {
		public function getType();
	    public function process($filename, $userId);
	    public function validateData($data, $userId, &$arrayCustomers, &$arrayErrors, $idxRow);
	    public function upload($arrayCustomers, $numberErrors, $arrayErrors, $lastRow);
	    public function checkHeaders($inputHeaders);
	    public function getArrayErrors($arrayErrors);
	}

?>