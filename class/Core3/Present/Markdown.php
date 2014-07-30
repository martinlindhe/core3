<?php
namespace Core3\Present;

/**
 * Wrapper for php-markdown
 */
class Markdown
{
    public static function render($text)
    {
        return \Michelf\Markdown::defaultTransform($text);
    }
}
