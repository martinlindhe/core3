<?php
namespace Writer;

/**
 * INI file writer
 */
class Ini
{
    public static function render(\Structure\IniFile $struct)
    {
        return implode("\n", $struct->lines);
    }

    public static function renderToFile(\Structure\IniFile $struct, $fileName)
    {
        $data = self::render($struct);
        file_put_contents($fileName, $data);
    }
}
