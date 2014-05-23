<?php
namespace Web;

/**
 * @group Web
 */
class RequestRouterTest extends \PHPUnit_Framework_TestCase
{
    function test1()
    {
        $router = new \Web\RequestRouter();
        $router->route('/');  // root request

        // TODO: verify output, for example request page not found and check that we get a 404 return. load start page and check that we get a 200 OK

    }
}
