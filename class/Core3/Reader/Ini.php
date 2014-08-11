<?php
namespace Core3\Reader;

/**
 * INI file reader
 */
class Ini
{
    /**
     * @return \Core3\Structure\IniFile representing the content
     */
    public static function parse($data)
    {
        $res = new \Core3\Structure\IniFile();
        if (!$data) {
            return $res;
        }

        $data = str_replace("\r\n", "\n", $data);
        $res->lines = explode("\n", $data);

        return $res;
    }

    public static function parseFile($fileName)
    {
        return self::parse(file_get_contents($fileName));
    }
}
