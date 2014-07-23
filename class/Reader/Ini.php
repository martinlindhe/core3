<?php
namespace Reader;

/**
 * INI file reader
 */
class Ini
{
    /**
     * @return \Structure\IniFile representing the content
     */
    public static function parse($data)
    {
        $res = new \Structure\IniFile();

        $data = str_replace("\r\n", "\n", $data);
        $res->lines = explode("\n", $data);

        return $res;
    }
}
