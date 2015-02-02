<?php

	require_once("BaseFileHandler.php");
	require_once("../../app/View/Utils/spreadsheetUtils.php");
	require_once("../../app/View/Utils/loadBar.php");
	require_once("../../app/Lib/ParseCSV/parsecsv.lib.php");

  	class CSVHandlerImpl extends BaseFileHandler {

  		private $delimiter;

  		public function __construct() {
  			$this->type = CSV_EXTENSION;
  			$this->delimiter = CSV_DELIMITER;
  		}

	    public function process($inputFilename, $userId) {

	    	$this->startTime = time();

	    	$csv = new parseCSV($inputFilename);
	    	$csvData = $csv->data;
			$idxRow = 1;
			$lastRow = count($csvData);

			$numberErrors = 0;
			$arrayCustomers = array();
			$arrayErrors = array();
			$processEnd = false;

			resetNumbers();
			writeNumbers($lastRow*2);

			foreach($csvData as $row) {
				foreach($row as $header => $value) {
					$headers = explode(';', $header);
					$validateHeaders = $this->checkHeaders($headers);
					if (!is_null($validateHeaders)) {
						return $validateHeaders;
					}

					$numberColumns = count($this->headers);
					$data = array();
					$valuesRow = explode(';', $value);
					$idxCol = 0;
					foreach($valuesRow as $value) {
						if ($idxCol < $numberColumns) {
							$data[$idxCol] = $value;
						}
						$idxCol += 1;
					}

					$validationErrors = $this->validateData($data, $userId, $arrayCustomers, $arrayErrors, $idxRow);
					if (is_null($validationErrors)) {
						$processEnd = true;
						break;
					}

					$numberErrors += $validationErrors;

					updateProgress($idxRow);
					$idxRow += 1;
				}

				if ($processEnd) {
					break;
				}
			}

			updateProgress($lastRow);
			return $this->upload($arrayCustomers, $numberErrors, $arrayErrors, $lastRow);
		}
	}
?>