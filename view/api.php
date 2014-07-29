<?php
/**
 * Handle API calls
 */

// shifts first parameter off array, so called api view have correct $param
$viewName = array_shift($param);

header('Content-Type: application/json; charset=UTF-8');

$apiRouter = new \Core3\Api\ApiRouter();
$apiRouter->setApplicationDirectoryRoot($this->applicationDirectoryRoot);

$apiRouter->routeView($viewName, $param, $_SERVER['REQUEST_METHOD']);
