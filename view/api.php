<?php
/**
 * Handle API calls
 */

// shifts first parameter off array, so called api view have correct $param
$viewName = array_shift($param);

header('Content-Type: application/json; charset=UTF-8');


// first, look in app/api/routname.php
$apiViewFileName = $this->applicationDirectoryRoot.'/api/'.$viewName.'.php';
if (!file_exists($apiViewFileName)) {
    // next, look in core3/api/routename.php
    $apiViewFileName = __DIR__.'/../api/'.$viewName.'.php';
    if (!file_exists($apiViewFileName)) {
        $this->setHttpResponseCode(400); // Bad Request
        echo \Core3\Writer\Json::encodeSlim(array('error' => 'route not available'));
        die;
    }
}

try {
    include $apiViewFileName;
} catch (\FileNotFoundException $ex) {
    $this->setHttpResponseCode(404); // File Not Found
    echo \Core3\Api\ResponseError::exceptionToJson($ex);
} catch (\Exception $ex) {
    $this->setHttpResponseCode(400); // Bad Request
    echo \Core3\Api\ResponseError::exceptionToJson($ex);
}
