<?php
namespace Core3\Writer;

/**
 * Generates UUID:s, which
 * is a 128-bit (16 byte) number
 */
class Uuid
{
    public static function isValid($uuid)
    {
        return preg_match(
            '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i',
            $uuid
        ) === 1;
    }

    /**
     * @param $ns namespace
     * @param $name name
     * @return a v3 UUID (md5 of $name)
     */
    public static function v3($ns, $name)
    {
        $hash = md5(self::toBinary($ns).$name);
        return self::build($hash, 0x3000);
    }

    /**
     * @return a v4 UUID (randomized value)
     */
    public static function v4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    /**
     * @param $ns namespace
     * @param $name name
     * @return a v5 UUID (sha1 of $name)
     */
    public static function v5($ns, $name)
    {
        $hash = sha1(self::toBinary($ns).$name);
        return self::build($hash, 0x5000);
    }

    private static function build($hash, $version)
    {
        return sprintf(
            '%08s-%04s-%04x-%04x-%12s',
            // 32 bits "time_low"
            substr($hash, 0, 8),
            // 16 bits "time_mid"
            substr($hash, 8, 4),
            // 16 bits "time_hi_and_version",
            // four most significant bits holds version number
            (hexdec(substr($hash, 12, 4)) & 0x0fff) | $version,
            // 16 bits, 8 bits "clk_seq_hi_res", 8 bits "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
            // 48 bits "node"
            substr($hash, 20, 12)
        );
    }

    /**
     * Creates 32-letter hex string to 16-byte binary string of input UUID
     */
    public static function toBinary($uuid)
    {
        if (!self::isValid($uuid)) {
            throw new \Exception('invalid input');
        }

        $hex = str_replace(array('-','{','}'), '', $uuid);

        $res = '';

        for ($i = 0; $i < strlen($hex); $i+=2)
            $res .= chr(hexdec($hex[$i].$hex[$i+1]));

        return $res;
    }

    /**
     * Converts a UUID-formatted string to a hex value
     * @param $uuid UUID as a string "3F2504E0-4F89-11D3-9A0C-0305E82C3301"
     * @return UUID as a string "E004253F894FD3119A0C0305E82C3301" (RAW 16)
     */
    public static function toHex($uuid)
    {
        if (!self::isValid($uuid)) {
            throw new \Exception('invalid input');
        }

        $uuid = str_replace(array('{','}'), '', $uuid);

        if (strlen($uuid) != 36) {
            throw new \Exception('invalid input');
        }

        $parts = explode('-', $uuid);
        if (count($parts) != 5) {
            throw new \Exception('invalid input');
        }

        if (strlen($parts[0]) != 8 || strlen($parts[1]) != 4 ||
            strlen($parts[2]) != 4 || strlen($parts[3]) != 4 ||
            strlen($parts[4]) != 12) {
            return false;
        }

        //Data4 stores the bytes in the same order as displayed in the GUID text encoding,
        //but other three fields are reversed on little-endian systems (e.g. Intel CPUs).
        return self::strrev2($parts[0]).self::strrev2($parts[1]).self::strrev2($parts[2]).$parts[3].$parts[4];
    }

    /**
     * Like built in strrev() but on character pairs
     * @param $str input string, must have even length
     */
    private static function strrev2($str)
    {
        if (strlen($str) % 2) {
            throw new \Exception('invalid input');
        }

        $ret = '';
        for ($i = strlen($str); $i >= 0; $i -= 2) {
            $ret .= substr($str, $i, 2);
        }
        return $ret;
    }
}
