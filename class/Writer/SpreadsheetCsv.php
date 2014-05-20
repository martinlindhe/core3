<?php

class Writer_SpreadsheetCsv extends Writer_Spreadsheet
{
	private $delimiter = ';';
	private $lineEnding = "\r\n";

	public function setDelimiter($delim) { $this->delimiter = $delim; }
	public function setLineEnding($ending) { $this->lineEnding = $ending; }

	public static function sendHttpAttachmentHeaders($fileName)
	{
		$header = new Writer_HttpHeader();
		$header->sendContentType('text/csv');
		$header->sendAttachment($fileName);
		$header->sendNoCacheHeaders();
	}

	public function render(Model_Spreadsheet $model)
	{
		return
		$this->renderHeader($model).
		$this->renderBody($model);
	}

	private function renderHeader(Model_Spreadsheet $model)
	{
		if (!$model->getColumns()) {
			return '';
		}

		return
			implode(self::escapeRow($model->GetColumns()), $this->delimiter).
			$this->lineEnding;
	}

	private function renderBody(Model_Spreadsheet $model)
	{
		$res = '';

		foreach ($model->getRows() as $row) {
			$res .=
				implode($this->escapeRow($row), $this->delimiter).
				$this->lineEnding;
		}

		return $res;
	}

	private function escapeRow(array $row)
	{
		$fixed = array();

		foreach ($row as $col) {
			$fixed[] = $this->escapeString($col);
		}

		return $fixed;
	}

	private static function isDoubleQuoted($s)
	{
		if (strpos($s, '"') !== false) {
			return true;
		}

		return false;
	}

	private static function containsSeparatorCharacter($s)
	{
		if (strpos($s, ";")  !== false || strpos($s, ",") !== false || strpos($s, "\t") !== false) {
			return true;
		}

		return false;
	}

	private static function containsPadding($s)
	{
		if (substr($s, 0, 1) == ' ' || substr($s, -1) == ' ') {
			return true;
		}

		return false;
	}

	private static function containsLineFeed($s)
	{
		if (strpos($s, "\r") !== false || strpos($s, "\n") !== false) {
			return true;
		}

		return false;
	}

	public static function escapeString($s)
	{
		if (self::IsDoubleQuoted($s)) {
			return '"'.str_replace('"', '""', $s).'"';
		}

		if (self::containsSeparatorCharacter($s) || self::containsPadding($s) || self::containsLineFeed($s)) {
			return '"'.$s.'"';
		}

		return $s;
	}
}
