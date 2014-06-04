<?php
namespace Web;

/**
 * @group Web
 */
class RequestRouterTest extends \PHPUnit_Framework_TestCase
{
    function testAppInHostRoot()
    {
        // NOTE: test config where the app is served from the root directory of the webserver, like http://localhost/
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot(__DIR__);
        //$router->setApplicationWebRoot('/app1');
        
        $res = $router->route('/');

        // TODO: verify output, for example request page not found and check that we get a 404 return.
        //       load start page and check that we get a 200 OK
    }

    function testAppInHostSubdirectory()
    {
        // NOTE: test config where the app is served from a subdirectory of the webserver, like http://localhost/app1
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot(__DIR__);
        $router->setApplicationWebRoot('/app1');
        
        $res = $router->route('/app1/');

        // TODO verify output
    }

    function testSstripApplicationPrefix()
    {
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot(__DIR__);

        $router->setApplicationWebRoot('/app1');

        $this->assertEquals(
            '/path/view',
            $router->stripApplicationPrefix('/app1/path/view')
        );

        $router->setApplicationWebRoot('/');

        $this->assertEquals(
            '/path/view',
            $router->stripApplicationPrefix('/path/view')
        );
    }

    function testRoutedResult404()
    {
        // NOTE: test config where the app is served from a subdirectory of the webserver, like http://localhost/app1
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot(__DIR__);
        $router->setApplicationWebRoot('/');
        
        $res = $router->route('/wrong/path');
        
        // TODO how can wwe verify http code is 404 ?
        
        $this->assertEquals(
            "<html>\n".
            "\n".
            "<title>404 error - file not found!</title>\n".
            "\n".
            "/wrong/path not found\n".
            "\n".
            "</html>\n",
            $res
        );

    }

    /**
     * @expectedException DirectoryNotFoundRexception
     */
    function testInvalidApplicationDirectoryRoot()
    {
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot('/no/such/path');
    }

    function testValidViewName()
    {
        $router = new \Web\RequestRouter();
        $this->assertEquals(true, $router->isValidViewName('index'));
        $this->assertEquals(false, $router->isValidViewName(str_repeat('a', 40)));
        $this->assertEquals(true, $router->isValidViewName('123numbers'));
        $this->assertEquals(true, $router->isValidViewName('MixedCase'));
        $this->assertEquals(true, $router->isValidViewName('with-line'));
        $this->assertEquals(false, $router->isValidViewName('with.dot'));
        $this->assertEquals(false, $router->isValidViewName('unicöde'));
    }
}
