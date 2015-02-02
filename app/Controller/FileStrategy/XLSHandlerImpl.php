<?php

	require_once("BaseFileHandler.php");
	require_once("../../app/Lib/PHPExcel/Classes/PHPExcel/IOFactory.php");
	require_once("../../app/View/Utils/spreadsheetUtils.php");
	require_once("../../app/View/Utils/loadBar.php");

  	class XLSHandlerImpl extends BaseFileHandler {

  		private $reader;

  		public function __construct() {
  			$this->type = XLS_EXTENSION;
  			$this->reader = EXCEL_XLS_READER;
  		}

	    public function process($inputFilename, $userId) {

	    	$this->startTime = time();

			$objReader = PHPExcel_IOFactory::createReader($this->reader);
			$objPHPExcel = $objReader->load($inputFilename);

			$sheetExists = $objPHPExcel->sheetNameExists(SHEET_CONTACTS);
			if (!$sheetExists) {
				return "The sheet called (".SHEET_CONTACTS.") doesn't exist. Please, check your file.";
			}

			$objPHPExcel->setActiveSheetIndexByName(SHEET_CONTACTS);
			$activeSheet = $objPHPExcel->getActiveSheet();

			$idxRow = 0;
			$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
			$rowIterator = $activeSheet->getRowIterator();

			$fileHeaders = $activeSheet->rangeToArray('A1:G1')[0];

			$validateHeaders = $this->checkHeaders($fileHeaders);
			if (!is_null($validateHeaders)) {
				return $validateHeaders;
			}

			$numberErrors = 0;
			$arrayCustomers = array();
			$arrayErrors = array();

			resetNumbers();
			writeNumbers($lastRow*2);

			foreach ($rowIterator as $row) {
				$data = array();
				$idxRow = $row->getRowIndex();

				if ($idxRow <= 1) {
					continue;
				}
				
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);

				$idxCol = 0;
				foreach ($cellIterator as $cell) {
					if (!is_null($cell) && $idxCol < 7) {
						$data[$idxCol] = $cell->getValue();
					}
					$idxCol += 1;
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