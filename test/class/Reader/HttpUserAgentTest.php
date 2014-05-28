<?php
namespace Reader;

/**
 * @group Reader
 */
class HttpUserAgentTest extends \PHPUnit_Framework_TestCase
{
    public function testUnknownBrowser()
    {
        $s = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Unknown', $b->name);
    }

    public function testFirefox1()
    {
        $s = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('2.0.0.11', $b->version);

        // browsers
        $this->assertEquals(true, HttpUserAgent::isFirefox($s));
        $this->assertEquals(false, HttpUserAgent::isMSIE($s));
        $this->assertEquals(false, HttpUserAgent::isChrome($s));
        $this->assertEquals(false, HttpUserAgent::isSafari($s));
        $this->assertEquals(false, HttpUserAgent::isOpera($s));

        // desktop OS
        $this->assertEquals(false, HttpUserAgent::isMacOsx($s));
        $this->assertEquals(true, HttpUserAgent::isWindows($s));
        $this->assertEquals(false, HttpUserAgent::isLinux($s));

        // mobile OS
        $this->assertEquals(false, HttpUserAgent::isAndroid($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidPhone($s));
        $this->assertEquals(false, HttpUserAgent::isIOS($s));
        $this->assertEquals(false, HttpUserAgent::isWindowsPhone($s));
        $this->assertEquals(false, HttpUserAgent::isBlackberry($s));
        $this->assertEquals(false, HttpUserAgent::isSymbian($s));

        // tablet
        $this->assertEquals(false, HttpUserAgent::isIpad($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidTablet($s));
        $this->assertEquals(false, HttpUserAgent::isWindowsSurface($s));

        // architecture
        $this->assertEquals(false, HttpUserAgent::isX86_64($s));
        $this->assertEquals(false, HttpUserAgent::isPowerPC($s));
        $this->assertEquals(false, HttpUserAgent::isARM($s));

        // simple checks
        $this->assertEquals(false, HttpUserAgent::isMobile($s));
        $this->assertEquals(true, HttpUserAgent::isDesktop($s));
        $this->assertEquals(false, HttpUserAgent::isTablet($s));
    }

    public function testFirefox2()
    {
        $s = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('3.6.8', $b->version);
        $this->assertEquals(false, HttpUserAgent::isWindows($s));
        $this->assertEquals(true, HttpUserAgent::isLinux($s));
        $this->assertEquals(true, HttpUserAgent::isX86_64($s));
    }

    public function testFirefox3()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64; rv:6.0) Gecko/20100101 Firefox/6.0';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('6.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox4()
    {
        $s = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('9.0.1', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
        $this->assertEquals('WOW64', $b->arch);
    }

    public function testFirefox5()
    {
        $s = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('10.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox6()
    {
        $s = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:10.0) Gecko/20100101 Firefox/10.0';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('10.0', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10.7', $b->arch);
        $this->assertEquals(true, HttpUserAgent::isMacOsx($s));
    }

    public function testFirefox7()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64; rv:28.0) Gecko/20100101 Firefox/28.0';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('28.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox8()
    {
        // latest stable as of 2014-04-24
        $s = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('28.0', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10.9', $b->arch);
    }

    public function testChrome1()
    {
        $s =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_7) '.
            'AppleWebKit/534.24 (KHTML, like Gecko) Chrome/11.0.696.68 Safari/534.24';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('11.0.696.68', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10_6_7', $b->arch);
    }

    public function testChrome2()
    {
        $s =
            'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) '.
            'Chrome/12.0.742.113 Safari/534.30';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('12.0.742.113', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
    }

    public function testChrome2b()
    {
        $s =
            'Mozilla/5.0 (Macintosh; PPC Mac OS X 10_6_7) '.
            'AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.790.0 Safari/535.1';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('14.0.790.0', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('PPC Mac OS X 10_6_7', $b->arch);
        $this->assertEquals(true, HttpUserAgent::isChrome($s));
        $this->assertEquals(true, HttpUserAgent::isMacOsx($s));
        $this->assertEquals(true, HttpUserAgent::isPowerPC($s));
    }

    public function testChrome3()
    {
        $s =
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML, like Gecko) '.
            'Chrome/16.0.912.75 Safari/535.7';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('16.0.912.75', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
        $this->assertEquals('WOW64', $b->arch);
    }

    public function testChrome4()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('16.0.912.77', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testChrome5()
    {
        $s =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.7 (KHTML, like Gecko) '.
            'Chrome/16.0.912.77 Safari/535.7';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('16.0.912.77', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10_7_3', $b->arch);
    }

    public function testChrome6()
    {
        // latest stable as of 2014-04-24
        $s =
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) '.
            'Chrome/34.0.1847.116 Safari/537.36';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('34.0.1847.116', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testSafari1()
    {
        // Safari 2.0.4 dont report version number
        $s = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.8 (KHTML, like Gecko) Safari/419.3';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('build 419.3', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X', $b->arch);
    }

    public function testSafari2()
    {
        $s =
            'Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US) '.
            'AppleWebKit/525.28 (KHTML, like Gecko) Version/3.2.2 Safari/525.28.1';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('3.2.2', $b->version);
        $this->assertEquals('Windows', $b->os);
        $this->assertEquals('Windows NT 5.2', $b->arch);
    }

    public function testSafari3()
    {
        $s =
            'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) '.
            'AppleWebKit/533.18.1 (KHTML, like Gecko) Version/4.0.5 Safari/531.22.7';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.5', $b->version);
        $this->assertEquals('Windows', $b->os);
        $this->assertEquals('Windows NT 6.0', $b->arch);
    }

    public function testSafari4()
    {
        $s =
            'Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_4_11; fr) '.
            'AppleWebKit/533.16 (KHTML, like Gecko) Version/5.0 Safari/533.16';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.0', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('PPC Mac OS X 10_4_11', $b->arch);
        $this->assertEquals(true, HttpUserAgent::isPowerPC($s));
    }

    public function testSafari5()
    {
        $s =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) '.
            'AppleWebKit/534.53.11 (KHTML, like Gecko) Version/5.1.3 Safari/534.53.10';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.1.3', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10_7_3', $b->arch);
    }

    public function testSafari6()
    {
        // latest stable as of 2014-04-24
        $s =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) '.
            'AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/537.75.14';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('7.0.3', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10_9_2', $b->arch);
    }

    public function testSafariIOS1()
    {
        $s =
            'Mozilla/5.0 (iPhone; U; CPU OS 3_2 like Mac OS X; en-us) '.
            'AppleWebKit/531.21.10 (KHTML, like Gecko) '.
            'Version/4.0.4 Mobile/7B334b Safari/531.21.10';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.4', $b->version);
        $this->assertEquals('iPhone', $b->os);
        $this->assertEquals('CPU OS 3_2 like Mac OS X', $b->arch);
        $this->assertEquals(false, HttpUserAgent::isIpad($s));
        $this->assertEquals(false, HttpUserAgent::isTablet($s));
    }

    public function testSafariIOS2()
    {
        $s =
            'Mozilla/5.0 (iPad;U;CPU OS 3_2_2 like Mac OS X; en-us) '.
            'AppleWebKit/531.21.10 (KHTML, like Gecko) '.
            'Version/4.0.4 Mobile/7B500 Safari/531.21.10';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.4', $b->version);
        $this->assertEquals('iPad', $b->os);
        $this->assertEquals('CPU OS 3_2_2 like Mac OS X', $b->arch);
        $this->assertEquals(true, HttpUserAgent::isIpad($s));
        $this->assertEquals(true, HttpUserAgent::isTablet($s));
    }

    public function testSafariIOS3()
    {
        $s =
            'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; ja-jp) '.
            'AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.0.2', $b->version);
        $this->assertEquals('iPod', $b->os);
        $this->assertEquals('CPU iPhone OS 4_3_3 like Mac OS X', $b->arch);
        $this->assertEquals(false, HttpUserAgent::isIpad($s));
        $this->assertEquals(false, HttpUserAgent::isTablet($s));
    }

    public function testSafariIOS4()
    {
        $s =
            'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) '.
            'AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.1', $b->version);
        $this->assertEquals('iPhone', $b->os);
        $this->assertEquals('CPU iPhone OS 5_0_1 like Mac OS X', $b->arch);
    }

    public function testSafariIOS5()
    {
        // version shipped with iOS 7.0.4, at 2014-04-24
        $s =
            'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0_4 like Mac OS X) '.
            'AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11B554a Safari/9537.53';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('iPhone', $b->os);
        $this->assertEquals('CPU iPhone OS 7_0_4 like Mac OS X', $b->arch);
    }

    public function testIe1()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 4.01; Windows 98)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('4.01', $b->version);
    }

    public function testIe2()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 5.23; Mac_PowerPC)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('5.23', $b->version);
        $this->assertEquals(true, HttpUserAgent::isPowerPC($s));
    }

    public function testIe3()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('6.0', $b->version);
    }

    public function testIe4()
    {
        $s = 'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('7.0', $b->version);
    }

    public function testIe5()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('8.0', $b->version);
    }

    public function testIe6()
    {
        $s = '"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('9.0', $b->version);
    }

    public function testIe7()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('10.0', $b->version);
        $this->assertEquals(false, HttpUserAgent::isWindowsSurface($s));
    }

    public function testIe8()
    {
        //latest stable as of 2014-04-24
        $s = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; Trident/7.0; rv:11.0) like Gecko';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('11.0', $b->version);
        $this->assertEquals(false, HttpUserAgent::isWindowsSurface($s));
    }

    public function testOpera1()
    {
        $s = 'Opera/9.00 (Windows NT 5.1; U; en)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('9.00', $b->version);
        $this->assertEquals('Windows NT 5.1', $b->os);
    }

    public function testOpera2()
    {
        $s = 'Opera/9.50 (Macintosh; Intel Mac OS X; U; en)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('9.50', $b->version);
        $this->assertEquals('Macintosh', $b->os);
    }

    public function testOpera3()
    {
        $s = 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.2.15 Version/10.00';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('10.00', $b->version);
        $this->assertEquals('X11', $b->os);
    }

    public function testOpera4()
    {
        $s = 'Opera/9.80 (Windows NT 6.0; U; en) Presto/2.8.99 Version/11.10';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('11.10', $b->version);
        $this->assertEquals('Windows NT 6.0', $b->os);
    }

    public function testOpera5()
    {
        // latest stable as of 2012-02-08
        $s = 'Opera/9.80 (Windows NT 6.1; U; en) Presto/2.10.229 Version/11.61';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('11.61', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
    }

    public function testAndroidPhone1()
    {
        // NOTE: Webkit based browser for the Android Mobile Platform
        $s =
        'Mozilla/5.0 (Linux; U; Android 2.3.4; fr-fr; HTC Desire Build/GRJ22) '.
        'AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';

        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isAndroid($s));
        $this->assertEquals(true, HttpUserAgent::isAndroidPhone($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidTablet($s));
        $this->assertEquals(false, HttpUserAgent::isLinux($s));
    }

    public function testAndroidTablet1()
    {
        $s =
        'Mozilla/5.0 (Linux; U; Android 3.0.1; en-us; Xoom Build/HRI66) '.
        'AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13';

        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isAndroid($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidPhone($s));
        $this->assertEquals(true, HttpUserAgent::isAndroidTablet($s));
    }

    public function testAndroidTablet2()
    {
        // NOTE detects "Samsung Galaxy Tab" incorrectly sets the "Mobile" part in UA
        $s =
        'Mozilla/5.0 (Linux; U; Android 2.2; en-us; SCH-I800 Build/FROYO) '.
        'AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';

        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isAndroid($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidPhone($s));
        $this->assertEquals(true, HttpUserAgent::isAndroidTablet($s));
    }

    public function testAndroidTablet3()
    {
        // NOTE old versions of "Amazon Kindle" incorrectly sets the "Mobile" part in UA
        $s =
        'Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; Kindle Fire Build/GINGERBREAD) '.
        'AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1';

        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isAndroid($s));
        $this->assertEquals(false, HttpUserAgent::isAndroidPhone($s));
        $this->assertEquals(true, HttpUserAgent::isAndroidTablet($s));
    }

    public function testWindowsMobile1()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows Phone OS 7.5; Trident/5.0; IEMobile/9.0)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isWindowsPhone($s));
        $this->assertEquals(false, HttpUserAgent::isWindows($s));
        $this->assertEquals(false, HttpUserAgent::isMSIE($s));
    }

    public function testBlackberry1()
    {
        // NOTE: Browser for the BlackBerry smartphone
        $s =
        'Mozilla/5.0 (BlackBerry; U; BlackBerry 9700; pt) '.
        'AppleWebKit/534.8+ (KHTML, like Gecko) Version/6.0.0.546 Mobile Safari/534.8+';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(false, HttpUserAgent::isAndroid($s));
        $this->assertEquals(true, HttpUserAgent::isBlackberry($s));
        $this->assertEquals(true, HttpUserAgent::isMobile($s));
        $this->assertEquals(false, HttpUserAgent::isDesktop($s));
    }

    public function testSymbian1()
    {
        $s =
        'Mozilla/5.0 (SymbianOS/9.4; Series60/5.0 NokiaC6-00/20.0.042; '.
        'Profile/MIDP-2.1 Configuration/CLDC-1.1; zh-hk) '.
        'AppleWebKit/525 (KHTML, like Gecko) BrowserNG/7.2.6.9 3gpp-gba';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isSymbian($s));

        $this->assertEquals(true, HttpUserAgent::isMobile($s));
        $this->assertEquals(false, HttpUserAgent::isDesktop($s));
    }

    public function testSurfaceRT1()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; ARM; Trident/6.0; Touch)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isMSIE($s));
        $this->assertEquals(true, HttpUserAgent::isWindowsSurface($s));
        $this->assertEquals(true, HttpUserAgent::isTablet($s));
        $this->assertEquals(true, HttpUserAgent::isARM($s));
    }

    public function testSurfacePro1()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Win64; x64; Trident/6.0; Touch)';
        $b = HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, HttpUserAgent::isMSIE($s));
        $this->assertEquals(true, HttpUserAgent::isWindowsSurface($s));
        $this->assertEquals(true, HttpUserAgent::isTablet($s));
        $this->assertEquals(false, HttpUserAgent::isARM($s));
    }
}
