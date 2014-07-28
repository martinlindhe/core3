<?php
namespace Core3\Structure;

// TODO handle escape sequences  "\;", "\=" etc, see http://en.wikipedia.org/wiki/INI_file#Escape_characters

/**
 * Represents a parsed INI file
 * Used by Reader\Ini and Writer\Ini
 */
class IniFile
{
    var $lines = array();

    public function get($section, $key)
    {
        $currentSection = '';
        $currentKey = '';

        foreach ($this->lines as $currentLine => $line) {

            if (substr($line, 0, 1) == '[' && substr($line, -1) == ']') {
                $currentSection = substr($line, 1, -1);
            }

            if (strpos($line, '=') === false) {
                continue;
            }
            list($currentKey, $val) = explode('=', $line, 2);

            if ($currentSection == $section && $currentKey == $key) {
                return $val;
            }
        }

        return false;
    }

    function set($section, $key, $val)
    {
        $currentSection = '';
        $currentKey = '';

        foreach ($this->lines as $currentLine => $line) {

            if (substr($line, 0, 1) == '[' && substr($line, -1) == ']') {
                $currentSection = substr($line, 1, -1);
            }

            $separatorPos = strpos($line, '=');
            if ($separatorPos === false) {
                continue;
            }

            $currentKey = substr($line, 0, $separatorPos);

            if ($currentSection == $section && $currentKey == $key) {
                $this->lines[$currentLine] = $key.'='.$val;
                return;
            }
        }
    }
}
