<?php
/**
 * This is the application router
 */

require_once 'bootstrap.php';

$request = '';
if (isset($_SERVER['REDIRECT_URL'])) {
    $request = $_SERVER['REDIRECT_URL'];
} else if (isset($_SERVER['REQUEST_URI'])) {
    $request = $_SERVER['REQUEST_URI'];
}

if (!isset($_SERVER['REQUEST_METHOD'])) {
    die('error');
}
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router = new \Core3\Web\RequestRouter();
$router->setApplicationDirectoryRoot(__DIR__);
$router->setApplicationWebRoot(dirname($_SERVER['SCRIPT_NAME']));

\Core3\Writer\HttpHeader::sendContentType('text/html; charset=utf-8');

echo $router->route($request, $requestMethod);
