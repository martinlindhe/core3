<?php
namespace Core3\Writer;

/**
 * INI file writer
 */
class Ini
{
    public static function render(\Core3\Structure\IniFile $struct)
    {
        return trim(implode("\n", $struct->lines))."\n";
    }

    public static function renderToFile(\Core3\Structure\IniFile $struct, $fileName)
    {
        file_put_contents($fileName, self::render($struct));
    }
}
