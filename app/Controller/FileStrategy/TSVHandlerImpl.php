<?php

	require_once("BaseFileHandler.php");
	require_once("../../app/View/Utils/spreadsheetUtils.php");
	require_once("../../app/View/Utils/loadBar.php");
	require_once("../../app/Lib/ParseCSV/parsecsv.lib.php");

  	class TSVHandlerImpl extends BaseFileHandler {

  		private $delimiter;

  		public function __construct() {
  			$this->type = TSV_EXTENSION;
  			$this->delimiter = TSV_DELIMITER;
  		}

	    public function process($inputFilename, $userId) {

	    	$this->startTime = time();

	    	$tsv = new parseCSV();
	    	$tsv->delimiter = $this->delimiter;
	    	$tsv->parse($inputFilename);
	    	$tsvData = $tsv->data;
			$idxRow = 1;
			$lastRow = count($tsvData);

			$numberErrors = 0;
			$arrayCustomers = array();
			$arrayErrors = array();

			resetNumbers();
			writeNumbers($lastRow*2);

			foreach($tsvData as $row) {
				$headers = array();
				$data = array();
				$idxCol = 0;
				$numberColumns = count($row);
				foreach($row as $header => $value) {
					$headers[] = $header;

					if (!is_null($value) && $idxCol < $numberColumns) {
						$data[$idxCol] = $value;
					}

					$idxCol += 1;
				}

				$validateHeaders = $this->checkHeaders($headers);
				if (!is_null($validateHeaders)) {
					return $validateHeaders;
				}

				$validationErrors = $this->validateData($data, $userId, $arrayCustomers, $arrayErrors, $idxRow);
				if (is_null($validationErrors)) {
					break;
				}

				$numberErrors += $validationErrors;

				updateProgress($idxRow);
				$idxRow += 1;
			}

			updateProgress($lastRow);
			return $this->upload($arrayCustomers, $numberErrors, $arrayErrors, $lastRow);
		}
	}
?>