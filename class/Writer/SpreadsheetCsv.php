<?php

class Writer_SpreadsheetCsv extends Writer_Spreadsheet
{
    private $delimiter = ';';
    private $lineEnding = "\r\n";

    public function setDelimiter($delim)
    {
        $this->delimiter = $delim;
    }

    public function setLineEnding($ending)
    {
        $this->lineEnding = $ending;
    }

    public function sendHttpAttachmentHeaders($fileName)
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
            implode($this->escapeRow($model->GetColumns()), $this->delimiter).
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

    private function isDoubleQuoted($s)
    {
        if (strpos($s, '"') !== false) {
            return true;
        }

        return false;
    }

    private function containsSeparatorCharacter($s)
    {
        if (strpos($s, ";")  !== false || strpos($s, ",") !== false || strpos($s, "\t") !== false) {
            return true;
        }

        return false;
    }

    private function containsPadding($s)
    {
        if (substr($s, 0, 1) == ' ' || substr($s, -1) == ' ') {
            return true;
        }

        return false;
    }

    private function containsLineFeed($s)
    {
        if (strpos($s, "\r") !== false || strpos($s, "\n") !== false) {
            return true;
        }

        return false;
    }

    public function escapeString($s)
    {
        if ($this->isDoubleQuoted($s)) {
            return '"'.str_replace('"', '""', $s).'"';
        }

        if ($this->containsSeparatorCharacter($s) || $this->containsPadding($s) || $this->containsLineFeed($s)) {
            return '"'.$s.'"';
        }

        return $s;
    }
}
