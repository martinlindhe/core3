<?php
/**
* Compile SCSS to CSS stylesheets on demand
*/

$viewName = $param[0]; ///< base name of the scss file

$scss = new \Writer\Scss();

$scss->setImportPath($this->applicationDirectoryRoot.'/scss');

header('Content-Type: text/css');

try {
    if ($requestMethod != 'GET') {
        throw new \Exception('only GET supported');
    }

    echo $scss->handleRequest($viewName);

} catch (\CachedInClientException $ex) {

    http_response_code(304); // Not Modified

} catch (\Exception $ex) {

    http_response_code(400); // Bad Request
    header('Content-Type: application/json');
    echo \Api\ResponseError::exceptionToJson($ex);
}
