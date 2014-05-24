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
        $router->route('/');

        // TODO: verify output, for example request page not found and check that we get a 404 return.
        //       load start page and check that we get a 200 OK
    }

    function testAppInHostSubdirectory()
    {
        // NOTE: test config where the app is served from a subdirectory of the webserver, like http://localhost/app1
        $router = new \Web\RequestRouter();
        $router->setApplicationDirectoryRoot(__DIR__);
        $router->setApplicationWebRoot('/app1');
        $router->route('/app1/');

        // TODO verify output
    }

    /**
     * @expectedException InvalidDirectoryRexception
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
        $this->assertEquals(false, $router->isValidViewName(str_repeat('a', 25))); // max 20 letter view name
        $this->assertEquals(false, $router->isValidViewName('123numbers'));
        $this->assertEquals(false, $router->isValidViewName('MixedCase'));
        $this->assertEquals(false, $router->isValidViewName('unicöde'));
    }
}
