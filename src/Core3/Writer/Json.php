<?php
namespace Core3\Writer;

/**
 * Supports PHP 5.3 and up
 */
class Json
{
    /**
     * Encodes object to JSON string
     * @param type $obj
     * @return string
     */
    public static function encode($obj)
    {
        return json_encode($obj);
    }

    private static function stripNullValuesFromJson($json)
    {
        return preg_replace(
            '/,\s*"[^"]+":null|"[^"]+":null,?/',
            '',
            $json
        );
    }

    /**
     * Encodes object to JSON string, excluding null values
     */
    public static function encodeSkipNullValues($obj)
    {
        return self::stripNullValuesFromJson(json_encode($obj));
    }

    /**
     * Encodes object to JSON string, without escaping unicode or slashes and no null values
     * @param type $obj
     * @return string
     */
    public static function encodeSlim($obj)
    {
        if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            $json = json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } else {
            // NOTE: for compatibility with php 5.3
            $json = self::unescapeSlashes(self::unescapeUnicode(json_encode($obj)));
        }

        return self::stripNullValuesFromJson($json);
    }

    /**
     * Converts escaped slashes from json string, simulating JSON_UNESCAPED_SLASHES
     * in versions before php 5.4
     * @param type $rawJson
     * @return string
     */
    private static function unescapeSlashes($rawJson)
    {
        return str_replace('\\/', '/', $rawJson);
    }

    /**
     * Decodes \u00xx (utf8 encoding) from json string, simulating JSON_UNESCAPED_UNICODE
     * in versions before php 5.4
     * @param string $rawJson
     * @return string
     */
    private static function unescapeUnicode($rawJson)
    {
        return preg_replace(
            "/\\\\u([a-f0-9]{4})/e",
            "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))",
            $rawJson
        );
    }
}
