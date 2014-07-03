<?php
/**
 * Handle API calls
 */

$viewName = $param[0]; ///< name of the api call

header('Content-Type: application/json');

// first, look in app api/routname.php
$apiViewFileName = $this->applicationDirectoryRoot.'/api/'.$viewName.'.php';
if (!file_exists($apiViewFileName)) {
    // next, look in core3/api/routename.php
    $apiViewFileName = __DIR__.'/../../api/'.$viewName.'.php';
    if (!file_exists($apiViewFileName)) {
        http_response_code(400); // Bad Request
        echo \Writer\Json::encodeSlim(array('error' => 'route not available'));
        die;
    }
}

try {
    include $apiViewFileName;
} catch (\Exception $ex) {
    http_response_code(400); // Bad Request
    echo \Api\ResponseError::exceptionToJson($ex);
}
