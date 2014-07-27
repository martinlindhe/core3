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

$router = new \Web\RequestRouter();
$router->setApplicationDirectoryRoot(__DIR__);
$router->setApplicationWebRoot(dirname($_SERVER['SCRIPT_NAME']));

\Writer\HttpHeader::sendContentType('text/html; charset=utf-8');

echo $router->route($request, $requestMethod);
