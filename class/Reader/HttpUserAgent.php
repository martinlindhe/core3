<?php
namespace Reader;

class WebBrowser // TODO move properties to HttpUserAgent class and use that?
{
    var $name;
    var $version;
    var $os;
    var $arch;
}

class HttpUserAgent
{
    /**
     * @return true if user agent is a iOS device
     */
    public static function isIOS($s)
    {
        $b = self::getBrowser($s);
        if (in_array($b->os, array('iPhone', 'iPad', 'iPod'))) {
            return true;
        }

        return false;
    }

    public static function isIpad($s)
    {
        if (self::isIOS($s) === true && strpos($s, 'iPad') !== false) {
            return true;
        }

        return false;
    }

    public static function isMacOsx($s)
    {
        if (strpos($s, 'Mac OS X') !== false) {
            return true;
        }
        return false;
    }

    public static function isWindows($s)
    {
        if (strpos($s, 'Windows') !== false &&
            strpos($s, 'Windows Phone') === false
        ) {
            return true;
        }
        return false;
    }

    public static function isWindowsPhone($s)
    {
        if (strpos($s, 'Windows Phone') !== false
        ) {
            return true;
        }
        return false;
    }

    public static function isBlackberry($s)
    {
        if (strpos($s, 'BlackBerry') !== false
        ) {
            return true;
        }
        return false;
    }

    public static function isWindowsSurface($s)
    {
        if (self::isMSIE($s) && strpos($s, 'Touch') !== false) {
            return true;
        }
        return false;
    }

    public static function isLinux($s)
    {
        if (strpos($s, 'Linux') !== false &&
            strpos($s, 'Android') === false
        ) {
            return true;
        }
        return false;
    }

    public static function isAndroid($s)
    {
        if (strpos($s, 'Android') !== false) {
            return true;
        }
        return false;
    }

    public static function isAndroidPhone($s)
    {
        if (strpos($s, 'Android') !== false &&
            strpos($s, 'Mobile') !== false &&
            !self::isAndroidTabletSpecialDetection($s)
        ) {
            return true;
        }
        return false;
    }


    public static function isAndroidTablet($s)
    {
        if (strpos($s, 'Android') !== false &&
            (
                strpos($s, 'Mobile') === false ||
                self::isAndroidTabletSpecialDetection($s)
            )
        ) {
            return true;
        }
        return false;
    }

    /**
     * Several Android tablets dont identify themselves as expected, by sending
     * "Safari Mobile".  we work around this by device-model identification
     */
    protected static function isAndroidTabletSpecialDetection($s)
    {
        if (
            strpos($s, 'SCH-I800') ||   // Samsung Galaxy Tab
            strpos($s, 'Kindle')        // Amazon Kindle
        ) {
            return true;
        }
        return false;
    }

    public static function isSymbian($s)
    {
        if (strpos($s, 'SymbianOS') !== false) {
            return true;
        }
        return false;
    }

    /**
     * @return true if browser is X86-64
     */
    public static function isX86_64($s)
    {
        if (strpos($s, 'x86_64') !== false ||
            strpos($s, 'x64') !== false ||
            strpos($s, 'Win64') !== false ||
            strpos($s, 'WOW64') !== false
        ) {
            return true;
        }
        return false;
    }

    public static function isPowerPC($s)
    {
        if (strpos($s, 'PowerPC') !== false ||
            strpos($s, 'PPC Mac OS X') !== false
        ) {
            return true;
        }
        return false;
    }

    public static function isARM($s)
    {
        if (strpos($s, 'ARM') !== false) {
            return true;
        }
        return false;
    }

    public static function isMSIE($s)
    {
        if ((strpos($s, 'MSIE') !== false ||
            strpos($s, 'Trident/') !== false) &&
            strpos($s, 'IEMobile') === false
        ) {
            return true;
        }
        return false;
    }

    public static function isFirefox($s)
    {
        if (strpos($s, 'Firefox') !== false) {
            return true;
        }
        return false;
    }

    public static function isChrome($s)
    {
        if (strpos($s, 'Chrome') !== false) {
            return true;
        }
        return false;
    }

    public static function isSafari($s)
    {
        if (strpos($s, 'Safari') !== false &&
            strpos($s, 'Mobile Safari') === false
        ) {
            return true;
        }
        return false;
    }

    public static function isOpera($s)
    {
        if (strpos($s, 'Opera') !== false) {
            return true;
        }
        return false;
    }

    public static function isMobile($s)
    {
        if (self::isAndroid($s) ||
            self::isIOS($s) ||
            self::isWindowsPhone($s) ||
            self::isBlackberry($s) ||
            self::isSymbian($s)
        ) {
            return true;
        }

        return false;
    }

    public static function isDesktop($s)
    {
        if (self::isMacOsx($s) ||
            self::isWindows($s) ||
            self::isLinux($s)
        ) {
            return true;
        }

        return false;
    }

    public static function isTablet($s)
    {
        if (self::isIpad($s) ||
            self::isAndroidTablet($s) ||
            self::isWindowsSurface($s)
        ) {
            return true;
        }
        return false;
    }

    /**
     * @return WebBrowser object
     */
    public static function getBrowser($s)
    {
        if (self::isFirefox($s)) {
            return self::parseFirefoxUA($s);
        }

        if (self::isChrome($s)) {
            return self::parseChromeUA($s);
        }

        if (self::isSafari($s)) {
            return self::parseSafariUA($s);
        }

        if (self::isOpera($s)) {
            return self::parseOperaUA($s);
        }

        if (self::isMSIE($s)) {
            return self::parseInternetExplorerUA($s);
        }

        $o = new WebBrowser();
        $o->name = 'Unknown';
        return $o;
    }

    private static function parseFirefoxUA($s)
    {
        $o = new WebBrowser();
        $o->name   = 'Firefox';

        $token = 'Mozilla/5.0 (';
        $pos = strpos($s, $token);
        if ($pos !== false) {
            $str = substr($s, $pos + strlen($token));

            $subPos = strpos($str, ')');
            $subStr = substr($str, 0, $subPos);

            foreach (explode(';', $subStr) as $tok) {
                $tok = trim($tok);
                if (stripos($tok, 'X11') !== false ||
                    stripos($tok, 'Windows') !== false ||
                    stripos($tok, 'Macintosh') !== false
                ) {
                    $o->os = $tok;
                } else if (
                    stripos($tok, 'WOW64') !== false ||
                    stripos($tok, 'x86') !== false ||
                    stripos($tok, 'Mac OS') !== false
                ) {
                    $o->arch = $tok;
                }
            }
        }

        $x = explode('Firefox/', $s, 2);
        $y = explode(' ', $x[1]);

        $o->version = $y[0];
        return $o;
    }

    private static function parseChromeUA($s)
    {
        $o = new WebBrowser();
        $o->name   = 'Chrome';

        $token = 'Mozilla/5.0 (';
        $pos = strpos($s, $token);
        if ($pos !== false) {
            $str = substr($s, $pos + strlen($token));

            $subPos = strpos($str, ')');
            $subStr = substr($str, 0, $subPos);

            $x = explode('; ', $subStr);

            // (Windows NT 6.1; WOW64)
            // (X11; Linux x86_64)
            $o->os   = trim($x[0]);
            if (isset($x[1]))
                $o->arch = trim($x[1]);
        }

        $x = explode('Chrome/', $s, 2);
        $y = explode(' ', $x[1]);

        $o->version = $y[0];
        return $o;
    }

    private static function parseSafariUA($s)
    {
        $o = new WebBrowser();
        $o->name   = 'Safari';

        // Beginning from version 3.0, the version number is part of the UA string as "Version/xxx"
        if (strpos($s, 'Version/') !== false) {
            $x = explode('Version/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        } else {
            $x = explode('Safari/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = 'build '.$y[0];
        }

        $token = 'Mozilla/5.0 (';
        $pos = strpos($s, $token);
        if ($pos !== false) {
            $str = substr($s, $pos + strlen($token));

            $subPos = strpos($str, ')');
            $subStr = substr($str, 0, $subPos);

            foreach (explode(';', $subStr) as $tok) {
                $tok = trim($tok);
                if (in_array($tok, array('Windows', 'Macintosh', 'iPhone', 'iPad', 'iPod'))) {
                    $o->os = $tok;
                } else if (
                    stripos($tok, 'Windows NT') !== false ||
                    stripos($tok, 'Mac OS') !== false
                ) {
                    $o->arch = $tok;
                }
            }
        }
        return $o;
    }

    private static function parseOperaUA($s)
    {
        $o = new WebBrowser();
        $o->name   = 'Opera';

        // Beginning from version 10.00, the version number is part of the UA string as "Version/xxx"
        if (strpos($s, 'Version/') !== false) {
            $x = explode('Version/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        } else {
            $x = explode('Opera/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        }

        $x = explode(' (', $s, 2);

        $subToken = $x[1];

        $pos = strpos($subToken, ')');
        $subStr = substr($subToken, 0, $pos);

        foreach (explode(';', $subStr) as $tok) {
            $tok = trim($tok);
            if (stripos($tok, 'X11') !== false ||
                stripos($tok, 'Windows') !== false ||
                stripos($tok, 'Macintosh') !== false
            ) {
                $o->os = $tok;
            } else if (
                stripos($tok, 'x86') !== false ||
                stripos($tok, 'Mac OS') !== false
            ) {
                $o->arch = $tok;
            }
        }
        return $o;
    }

    private static function parseInternetExplorerUA($s)
    {
        //TODO: parse os & arch for IE
        $o = new WebBrowser();
        $o->name   = 'Internet Explorer';

        if (strpos($s, 'MSIE') !== false) {
            // this format was used up to & including IE 10
            $x = explode('MSIE ', $s, 2);
            $y = explode(';', $x[1]);
            $o->version = $y[0];
            return $o;
        }

        // this format is used in IE 11 and forward
        $x = explode('rv:', $s, 2);
        $y = explode(')', $x[1]);
        $o->version = $y[0];
        return $o;
    }
}
