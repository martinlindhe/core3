<?php
/**
 * @group Reader
 */

class Reader_HttpUserAgentTest extends \PHPUnit_Framework_TestCase
{
    public function testUnknownBrowser()
    {
        $s = 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Unknown', $b->name);
    }

    public function testFirefox1()
    {
        $s = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; it; rv:1.8.1.11) Gecko/20071127 Firefox/2.0.0.11';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('2.0.0.11', $b->version);
        $this->assertEquals(true, Reader_HttpUserAgent::isFirefox($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isMSIE($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isChrome($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isSafari($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isOpera($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isIOS($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isMacOsx($s));
        $this->assertEquals(true, Reader_HttpUserAgent::isWindows($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isLinux($s));
        $this->assertEquals(false, Reader_HttpUserAgent::isX86_64($s));
    }

    public function testFirefox2()
    {
        $s = 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2.8) Gecko/20100723 Ubuntu/10.04 (lucid) Firefox/3.6.8';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('3.6.8', $b->version);
        $this->assertEquals(false, Reader_HttpUserAgent::isWindows($s));
        $this->assertEquals(true, Reader_HttpUserAgent::isLinux($s));
        $this->assertEquals(true, Reader_HttpUserAgent::isX86_64($s));
    }

    public function testFirefox3()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64; rv:6.0) Gecko/20100101 Firefox/6.0';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('6.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox4()
    {
        $s = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('9.0.1', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
        $this->assertEquals('WOW64', $b->arch);
    }

    public function testFirefox5()
    {
        $s = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0) Gecko/20100101 Firefox/10.0';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('10.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox6()
    {
        $s = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:10.0) Gecko/20100101 Firefox/10.0';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('10.0', $b->version);
        $this->assertEquals('Macintosh', $b->os);
        $this->assertEquals('Intel Mac OS X 10.7', $b->arch);
        $this->assertEquals(true, Reader_HttpUserAgent::isMacOsx($s));
    }

    public function testFirefox7()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64; rv:28.0) Gecko/20100101 Firefox/28.0';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Firefox', $b->name);
        $this->assertEquals('28.0', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testFirefox8()
    {
        // latest stable as of 2014-04-24
        $s = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:28.0) Gecko/20100101 Firefox/28.0';
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('12.0.742.113', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
    }

    public function testChrome3()
    {
        $s =
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/535.7 (KHTML, like Gecko) '.
            'Chrome/16.0.912.75 Safari/535.7';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('16.0.912.75', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
        $this->assertEquals('WOW64', $b->arch);
    }

    public function testChrome4()
    {
        $s = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.77 Safari/535.7';
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Chrome', $b->name);
        $this->assertEquals('34.0.1847.116', $b->version);
        $this->assertEquals('X11', $b->os);
        $this->assertEquals('Linux x86_64', $b->arch);
    }

    public function testSafari1()
    {
        // Safari 2.0.4 dont report version number
        $s = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/418.8 (KHTML, like Gecko) Safari/419.3';
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.5', $b->version);
        $this->assertEquals('Windows', $b->os);
        $this->assertEquals('Windows NT 6.0', $b->arch);
    }

    public function testSafari4()
    {
        $s =
            'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) '.
            'AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.0.4', $b->version);
        $this->assertEquals('Windows', $b->os);
        $this->assertEquals('Windows NT 6.1', $b->arch);
    }

    public function testSafari5()
    {
        $s =
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) '.
            'AppleWebKit/534.53.11 (KHTML, like Gecko) Version/5.1.3 Safari/534.53.10';
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
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
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, Reader_HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.4', $b->version);
        $this->assertEquals('iPhone', $b->os);
        $this->assertEquals('CPU OS 3_2 like Mac OS X', $b->arch);
    }

    public function testSafariIOS2()
    {
        $s =
            'Mozilla/5.0 (iPad;U;CPU OS 3_2_2 like Mac OS X; en-us) '.
            'AppleWebKit/531.21.10 (KHTML, like Gecko) '.
            'Version/4.0.4 Mobile/7B500 Safari/531.21.10';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, Reader_HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('4.0.4', $b->version);
        $this->assertEquals('iPad', $b->os);
        $this->assertEquals('CPU OS 3_2_2 like Mac OS X', $b->arch);
    }

    public function testSafariIOS3()
    {
        $s =
            'Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; ja-jp) '.
            'AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, Reader_HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('5.0.2', $b->version);
        $this->assertEquals('iPod', $b->os);
        $this->assertEquals('CPU iPhone OS 4_3_3 like Mac OS X', $b->arch);
    }

    public function testSafariIOS4()
    {
        $s =
            'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0_1 like Mac OS X) '.
            'AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A405 Safari/7534.48.3';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, Reader_HttpUserAgent::isIOS($s));
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
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals(true, Reader_HttpUserAgent::isIOS($s));
        $this->assertEquals('Safari', $b->name);
        $this->assertEquals('iPhone', $b->os);
        $this->assertEquals('CPU iPhone OS 7_0_4 like Mac OS X', $b->arch);
    }

    public function testIe1()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 4.01; Windows 98)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('4.01', $b->version);
    }

    public function testIe2()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 5.23; Mac_PowerPC)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('5.23', $b->version);
    }

    public function testIe3()
    {
        $s = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('6.0', $b->version);
    }

    public function testIe4()
    {
        $s = 'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('7.0', $b->version);
    }

    public function testIe5()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('8.0', $b->version);
    }

    public function testIe6()
    {
        $s = '"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Win64; x64; Trident/5.0)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('9.0', $b->version);
    }

    public function testIe7()
    {
        $s = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('10.0', $b->version);
    }

    public function testIe8()
    {
        //latest stable as of 2014-04-24
        $s = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; Trident/7.0; rv:11.0) like Gecko';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Internet Explorer', $b->name);
        $this->assertEquals('11.0', $b->version);
    }

    public function testOpera1()
    {
        $s = 'Opera/9.00 (Windows NT 5.1; U; en)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('9.00', $b->version);
        $this->assertEquals('Windows NT 5.1', $b->os);
    }

    public function testOpera2()
    {
        $s = 'Opera/9.50 (Macintosh; Intel Mac OS X; U; en)';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('9.50', $b->version);
        $this->assertEquals('Macintosh', $b->os);
    }

    public function testOpera3()
    {
        $s = 'Opera/9.80 (X11; Linux x86_64; U; en) Presto/2.2.15 Version/10.00';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('10.00', $b->version);
        $this->assertEquals('X11', $b->os);
    }

    public function testOpera4()
    {
        $s = 'Opera/9.80 (Windows NT 6.0; U; en) Presto/2.8.99 Version/11.10';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('11.10', $b->version);
        $this->assertEquals('Windows NT 6.0', $b->os);
    }

    public function testOpera5()
    {
        // latest stable as of 2012-02-08
        $s = 'Opera/9.80 (Windows NT 6.1; U; en) Presto/2.10.229 Version/11.61';
        $b = Reader_HttpUserAgent::getBrowser($s);
        $this->assertEquals('Opera', $b->name);
        $this->assertEquals('11.61', $b->version);
        $this->assertEquals('Windows NT 6.1', $b->os);
    }
}