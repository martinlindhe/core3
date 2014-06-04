<?php
namespace Model;

class Spreadsheet
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
    public function defineColumns($cols)
    {
		if (!is_array($cols) && !is_object($cols)) {
			throw new \InvalidArgumentException();
		}
        $this->columns = $cols;
    }

    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->AddRow($row);
        }
    }

    public function addRow($row)
    {
		if (!is_array($row) && !is_object($row)) {
			throw new \InvalidArgumentException();
		}

        if (count($this->columns) != 0 && count($row) != count($this->columns)) {
            throw new \InvalidArgumentException('column count mismatch');
		}

        $this->rows[] = $row;
    }

    public function setFooter($cols)
    {
		if (!is_array($cols) && !is_object($cols)) {
			throw new \InvalidArgumentException();
		}

        $this->footer = $cols;
    }
}
