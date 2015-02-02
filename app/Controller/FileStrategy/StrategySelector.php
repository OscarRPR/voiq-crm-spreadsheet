<?php

	require_once("XLSHandlerImpl.php");
	require_once("XLSXHandlerImpl.php");
	require_once("CSVHandlerImpl.php");
	require_once("TSVHandlerImpl.php");
	require_once("../../app/View/Utils/spreadsheetUtils.php");

	class StrategySelector {
		private $handlers;

		public function __construct() {
			$this->handlers = array(XLS_EXTENSION => new XLSHandlerImpl(),
									XLSX_EXTENSION => new XLSXHandlerImpl(),
									CSV_EXTENSION => new CSVHandlerImpl(),
									TSV_EXTENSION => new TSVHandlerImpl());
		}

		public function getHandler($extension) {
			if (isset($extension)) {
				if (array_key_exists($extension, $this->handlers)) {
					return $this->handlers[$extension];
				}
			}

			return null;
		}

		public function isFormatAvailable($format) {
			if (isset($format)) {
				foreach($this->handlers as $handler) {
					if ($handler->getType() == $format) {
						return true;
					}
				}
			}

			return false;
		}
	}

?>