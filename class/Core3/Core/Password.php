<?php
namespace Core3\Core;

abstract class Password
{
    public function getForbiddenPasswordsFilename()
    {
        return dirname(__FILE__).'/../../../data/Password.forbidden.txt';
    }

    public function isRepeatedLetter($s)
    {
        if (str_repeat(substr($s, 0, 1), strlen($s)) == $s) {
            return true;
        }

        return false;
    }

    /**
     * Matches "dadada"
     */
    public function isRepeatedLetterPair($s)
    {
        if (str_repeat(substr($s, 0, 2), strlen($s)/2) == $s) {
            return true;
        }

        return false;
    }

    /**
     * Matches "sexsex"
     */
    public function isRepeatedLetterTriplet($s)
    {
        if (str_repeat(substr($s, 0, 3), strlen($s)/3) == $s) {
            return true;
        }

        return false;
    }

    public function isRepeatingString($s)
    {
        if ($this->isRepeatedLetter($s) ||
            $this->isRepeatedLetterPair($s) ||
            $this->isRepeatedLetterTriplet($s)
        ) {
            return true;
        }

        return false;
    }

    public function isAllowed($password)
    {
        if ($this->isRepeatingString($password)) {
            return false;
        }

        $fileName = $this->getForbiddenPasswordsFilename();

        $data = file_get_contents($fileName);

        if (strpos($data, strtolower($password)) === false) {
            return true;
        }

        return false;
    }
}
