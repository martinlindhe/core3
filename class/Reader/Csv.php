<?php
namespace Reader;

class Csv
{
    private $delimiter = ',';
    private $startLine = 1;

    /**
     * @param string $s character separating CSV cells (usually , or ;)
     */
    public function setDelimiter($s)
    {
        $this->delimiter = $s;
    }

    /**
     * @param int $n starting line of csv data (1-based)
     */
    public function setStartLine($n)
    {
        $this->startLine = $n;
    }

    public function parse($data)
    {
        $res = array();

        $rows = explode("\n", $data);

        $line = 1;
        foreach ($rows as $row) {
            if ($line >= $this->startLine && $row) {
                $res[] = $this->parseRow($row);
            }
            $line++;
        }

        return $res;
    }

    public function parseFile($fileName)
    {
        return $this->parse(file_get_contents($fileName));
    }

    public function parseFileToObjects($fileName, $obj)
    {
        return $this->parseToObjects(file_get_contents($fileName), $obj);
    }

    public function parseToObjects($data, $objName)
    {
        $res = array();
        $rows = explode("\n", $data);
        $line = 1;

        foreach ($rows as $row) {
            if ($line >= $this->startLine && $row) {
                $res[] = $this->mapColumnsToObject($this->parseRow($row), $objName);
            }
            $line++;
        }

        return $res;
    }

    private function mapColumnsToObject($cols, $objName)
    {
        $res = new $objName;

        $i = 0;
        foreach ($res as $property => $value) {
            if (!isset($cols[$i])) {
                break;
            }
            $res->$property = $cols[$i++];
        }

        return $res;
    }

    /**
     * Parses a row of CSV data into a array
     *
     * @param $row line of raw CSV data to parse
     * @return array of parsed values
     */
    private function parseRow($row)
    {
        if (strpos($row, $this->delimiter) === false) {
            throw new \Exception('bad input');
        }

        $el = 0;
        $res = array();
        $inEscape = false;

        for ($i = 0; $i < strlen($row); $i++) {
            if (!isset($res[$el])) {
                $res[$el] = '';
            }

            $c = substr($row, $i, 1);

            if ($c == $this->delimiter) {
                if (!$inEscape) {
                    $el++;
                    $res[$el] = '';
                } else {
                    $res[$el] .= $c;
                }
            } else if ($c == '"') {
                $inEscape = !$inEscape;
                $res[$el] .= $c;
            } else {
                $res[$el] .= $c;
            }
        }

        // clean up escaped fields
        for ($i = 0; $i < count($res); $i++) {
            $res[$i] = $this->unescape($res[$i]);
        }

        return $res;
    }

    /**
     * Unescapes CSV data
     * @param $str string to unescape
     * @return unescaped string
     */
    private function unescape($str)
    {
        if (substr($str, -1) == "\r" || substr($str, -1) == "\n") {
            $str = rtrim($str); //strip lf
        }

        if (substr($str, 0, 1) == '"' && substr($str, -1) == '"') {
            $str = substr($str, 1, -1);
        }

        // embedded double-quote characters must be represented by a pair of double-quote characters
        $str = str_replace('""', '"', $str);

        return $str;
    }
}
