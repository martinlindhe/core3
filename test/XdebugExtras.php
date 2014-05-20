<?php

class XdebugExtras
{
    /**
     * @return array with all header lines matching $headerKey 
     */
    public static function findHeaders($headerKey)
    {
        $findKey = $headerKey.': '; 
        $len = strlen($findKey);
        $res = array();

        foreach (xdebug_get_headers() as $hdr) {
            if (substr($hdr, 0, $len) == $findKey) {
                $res[] = substr($hdr, $len);
            }
        }

        return $res;
    }
}
