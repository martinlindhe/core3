<?php
// TODO TEST
namespace Reader;

class Csv
{
    var $delimiter = ','; ///< character separating CSV cells (usually , or ;)
    var $startLine = 0;

    public function parse($data)
    {
        $res = array();

        $rows = explode("\n", $data);

        $line = 0;
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
        $in_esc = false;

        for ($i = 0; $i < strlen($row); $i++) {
            if (!isset($res[$el])) {
                $res[$el] = '';
            }

            $c = substr($row, $i, 1);

            if ($c == $this->delimiter) {
                if (!$in_esc) $el++;
                else $res[$el] .= $c;
            } else if ($c == '"') {
                $in_esc = !$in_esc;
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
