<?php
namespace Debug;

class HexPrinter
{
    var $rowLength = 16;
    var $fillChar = ' ';
    var $encodeHtml = false;

    /**
     * Pretty prints a binary string
     * @return string of hex + ascii values
     */
    public function render($m)
    {
        $j = 0;
        $bytes = '';
        $hex = '';
        $res = '';

        for ($i = 0; $i < strlen($m); $i++) {
            $x = substr($m, $i, 1);

            if (ord($x) > 30 && ord($x) < 0x80) {
                $bytes .= $this->encodeHtml ? htmlspecialchars($x) : $x;
            } else {
                $bytes .= '.';
            }

            $hex .= bin2hex($x).$this->fillChar;

            if (++$j == $this->rowLength) {
                $j = 0;
                $res .= $hex.' '.$bytes.$this->ln();
                $bytes = '';
                $hex = '';
            }
        }

        if ($j) {
            $res .=
                $hex.' '.
                str_repeat(' ', ($this->rowLength - strlen($bytes)) * 3).
                $bytes.$this->ln();
        }

        return $res;
    }

    private function ln()
    {
        return "\n";
    }
}
