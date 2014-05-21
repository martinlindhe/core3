<?php
/**
 * Parses the common browser user agent strings
 *
 * See http://www.useragentstring.com/
 *
 * @author Martin Lindhe, 2011-2014 <martin@ubique.se>
 */

//STATUS: wip

//TODO: parse os & arch for IE,   - TODO TODO IE parser was updated in core_dev?!?!

class WebBrowser
{
    var $vendor;    ///< string "Microsoft", "Google", "Mozilla"
    var $name;      ///< string "Chrome", "Firefox", "Internet Explorer"
    var $version;   ///< string "13.0.782.112", "6.0"
    var $os;        ///< string "Linux", "Windows", "Macintosh", "iPhone", "iPad", "iPod"
//    var $os_version; // string
    var $arch;      ///< string "x86_64", "CPU OS 3_2 like Mac OS X"
}

class HttpUserAgent
{
    /**
     * @return true if user agent is a iOS device
     */
    public function isIOS($s)
    {
        $b = $this->getBrowser($s);
        if (in_array($b->os, array('iPhone', 'iPad', 'iPod'))) {
            return true;
        }

        return false;
    }

    public function isMacOSX($s)
    {
        throw new Exception("TODO");
    }

    public function isWindows($s)
    {
        throw new Exception("TODO");
    }

    public function isLinux($s)
    {
        throw new Exception("TODO");
    }

    private function parseFirefoxUA($s)
    {
        $o = new WebBrowser();
        $o->vendor = 'Mozilla';
        $o->name   = 'Firefox';

        $tok1 = 'Mozilla/5.0 (';
        $p1 = strpos($s, $tok1);
        if ($p1 !== false) {
            $s1 = substr($s, $p1 + strlen($tok1) );

            $p2 = strpos($s1, ')');
            $s2 = substr($s1, 0, $p2);

            // (X11; Linux x86_64; rv:6.0)
            // (Windows NT 6.1; WOW64; rv:9.0.1)
            // (X11; Ubuntu; Linux x86_64; rv:10.0)
            // (Macintosh; Intel Mac OS X 10.7; rv:10.0)
            foreach (explode(';', $s2) as $tok) {
                $tok = trim($tok);
                if (stripos($tok, 'X11') !== false || stripos($tok, 'Windows') !== false || stripos($tok, 'Macintosh') !== false) {
                    $o->os = $tok;
                } else if (stripos($tok, 'WOW64') !== false || stripos($tok, 'x86') !== false || stripos($tok, 'Mac OS') !== false) {
                    $o->arch = $tok;
                } else {
                    // echo "unknown tok: ".$tok."\n";
                }
            }
        }

        // XXX FIXME use a regexp
        $x = explode('Firefox/', $s, 2);
        $y = explode(' ', $x[1]);

        $o->version = $y[0];

        return $o;
    }

    private function parseChromeUA($s)
    {
        $o = new WebBrowser();
        $o->vendor = 'Google';
        $o->name   = 'Chrome';

        $tok1 = 'Mozilla/5.0 (';
        $p1 = strpos($s, $tok1);
        if ($p1 !== false) {
            $s1 = substr($s, $p1 + strlen($tok1) );

            $p2 = strpos($s1, ')');
            $s2 = substr($s1, 0, $p2);

            $x = explode('; ', $s2);

            // (Windows NT 6.1; WOW64)
            // (X11; Linux x86_64)
            $o->os   = trim($x[0]);
            if (isset($x[1]))
                $o->arch = trim($x[1]);
        }

        // XXX FIXME use a regexp
        $x = explode('Chrome/', $s, 2);
        $y = explode(' ', $x[1]);

        $o->version = $y[0];
        return $o;
    }

    private function parseSafariUA($s)
    {
        $o = new WebBrowser();
        $o->vendor = 'Apple';
        $o->name   = 'Safari';

        // Beginning from version 3.0, the version number is part of the UA string as "Version/xxx"
        if (instr($s, 'Version/'))
        {
            $x = explode('Version/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        }
        else
        {
            // XXX FIXME use a regexp
            $x = explode('Safari/', $s, 2);
            $y = explode(' ', $x[1]);

            switch ($y[0]) {
            case '419.3':  $o->version = '2.0.4'; break;
            default: $o->version = 'build '.$y[0].' (unknown version)';
            }
        }

        $tok1 = 'Mozilla/5.0 (';
        $p1 = strpos($s, $tok1);
        if ($p1 !== false) {
            $s1 = substr($s, $p1 + strlen($tok1) );

            $p2 = strpos($s1, ')');
            $s2 = substr($s1, 0, $p2);

            // (iPhone; U; CPU OS 3_2 like Mac OS X; en-us)
            // (iPhone; CPU iPhone OS 5_0_1 like Mac OS X)
            // (iPad;U;CPU OS 3_2_2 like Mac OS X; en-us)
            // (Macintosh; U; Intel Mac OS X; en)
            // (Windows; U; Windows NT 6.1; en-US)
            // (Macintosh; Intel Mac OS X 10_7_3)
            foreach (explode(';', $s2) as $tok) {
                $tok = trim($tok);
                if ($tok == 'Windows' || $tok == 'Macintosh' || $tok == 'iPhone' || $tok == 'iPad' || $tok == 'iPod') {
                    $o->os = $tok;
                } else if (stripos($tok, 'Windows NT') !== false || stripos($tok, 'Mac OS') !== false) {
                    $o->arch = $tok;
                } else {
                    // echo "unknown tok: ".$tok."\n";
                }
            }
        }
        return $o;
    }

    private function parseOperaUA($s)
    {
        $o = new WebBrowser();
        $o->vendor = 'Opera Software';
        $o->name   = 'Opera';

        // Beginning from version 10.00, the version number is part of the UA string as "Version/xxx"
        if (instr($s, 'Version/')) {
            $x = explode('Version/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        }
        else {
            // XXX FIXME use a regexp
            $x = explode('Opera/', $s, 2);
            $y = explode(' ', $x[1]);
            $o->version = $y[0];
        }

        $x = explode(' (', $s, 2);

        $sub_s = $x[1];

        $p1 = strpos($sub_s, ')');
        $s2 = substr($sub_s, 0, $p1);

        // (Windows NT 5.1; U; en)
        // (Macintosh; Intel Mac OS X; U; en)
        // (X11; Linux x86_64; U; en)
        // (Windows NT 6.0; U; en)
        // (Windows NT 6.1; U; en)
        foreach (explode(';', $s2) as $tok) {
            $tok = trim($tok);
            if (stripos($tok, 'X11') !== false || stripos($tok, 'Windows') !== false || stripos($tok, 'Macintosh') !== false) {
                $o->os = $tok;
            } else if (stripos($tok, 'x86') !== false || stripos($tok, 'Mac OS') !== false) {
                $o->arch = $tok;
            } else {
                // echo "unknown tok: ".$tok."\n";
            }
        }
        return $o;
    }

    public function parseInternetExplorerUA($s)
    {
        $o = new WebBrowser();
        $o->vendor = 'Microsoft';
        $o->name   = 'Internet Explorer';

        $x = explode('MSIE ', $s, 2);
        $y = explode(';', $x[1]);
        $o->version = $y[0];
        return $o;
    }

    public function getBrowser($s)
    {
        if (instr($s, 'Firefox')) {
            return $this->parseFirefoxUA($s);
        }

        if (instr($s, 'Chrome')) {
            return $this->parseChromeUA($s);
        }

        if (instr($s, 'Safari')) {
            return $this->parseSafariUA($s);
        }

        if (instr($s, 'Opera')) {
            return $this->parseOperaUA($s);
        }

        if (instr($s, 'MSIE')) {
            return $this->parseInternetExplorerUA($s);
        }

        throw new Exception ("TODO return generic WebBrowser object");
    }
}
