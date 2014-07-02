<?php
/**
* Compile SCSS to CSS stylesheets on demand and
* serve file to browser client
*/

$viewName = $param[0]; ///< base name of the scss file

$scss = new \Writer\Scss();
$scss->setImportPath($this->applicationDirectoryRoot.'/scss');

header('Content-Type: text/css');

try {
    if ($requestMethod != 'GET') {
        throw new \Exception('only GET supported');
    }

    $data = $scss->renderView($viewName);
    $etag = '"'.md5($viewName.$scss->getCachedFileMtime($viewName)).'"';

    header('ETag: '.$etag);

    $timestamp = filemtime($scss->getCachedFileName($viewName));
    header('Last-Modified: '.gmdate('D, d M Y H:i:s ', $timestamp).'GMT');

    if (!$scss->isClientCacheDirty($etag)) {
        throw new \CachedInClientException();
    }
    echo $data;

} catch (\CachedInClientException $ex) {

    http_response_code(304); // Not Modified

} catch (\Exception $ex) {

    http_response_code(400); // Bad Request
    header('Content-Type: application/json');
    echo \Api\ResponseError::exceptionToJson($ex);
}
