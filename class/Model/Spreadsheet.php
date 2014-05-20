<?php

class Model_Spreadsheet
{
	private $columns = array();
	private $rows = array();
	private $footer = array();

	public function getColumns()
	{
		return $this->columns;
	}

	public function getRows()
	{
		return $this->rows;
	}

	public function getFooter()
	{
		return $this->footer;
	}

	/**
	 * Defines column names using an 1D array of strings
	 */
	public function defineColumns(array $cols)
	{
		$this->columns = $cols;
	}

	public function addRows(array $rows)
	{
		foreach ($rows as $row) {
			$this->AddRow($row);
		}
	}

	public function addRow(array $row)
	{
		if (count($this->columns) != 0 && count($row) != count($this->columns))
			throw new Exception('column count mismatch');

		$this->rows[] = $row;
	}

	public function setFooter(array $cols)
	{
		$this->footer = $cols;
	}
}
