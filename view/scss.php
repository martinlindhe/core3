<?php
/**
* Compile SCSS to CSS stylesheets on demand and
* serve file to browser client
*/


/**
 * @return true if the client has same version
 * of the document corresponding to $etag
 */
function isClientCachingDocument($etag)
{
    if (!isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
        return false;
    }

    if ($_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
        return true;
    }

    return false;
}


$viewName = $param[0]; ///< base name of the scss file

$scss = new \Core3\Writer\Scss();
$scss->setImportPath($this->applicationDirectoryRoot.'/scss');

header('Content-Type: text/css');

try {
    if ($requestMethod != 'GET') {
        throw new \Exception('only GET supported');
    }

    $scssFile = $scss->getScssFileName($viewName);
    if (!file_exists($scssFile)) {
        throw new \FileNotFoundException();
    }

    $cachedFile = $scss->getCachedFileName($viewName);

    if (file_exists($cachedFile)) {
        $orgMtime = filemtime($scssFile);
        $cacheMtime = filemtime($cachedFile);
        if ($cacheMtime > $orgMtime) {
            $data = file_get_contents($cachedFile);
        } else {
            // update cache
            $data = $scss->renderViewToCss($viewName);
            $scss->writeCache($cachedFile, $data);
        }
    } else {
        // create initial cached
        $data = $scss->renderViewToCss($viewName);
        $scss->writeCache($cachedFile, $data);
    }

    $etag = '"'.md5($viewName.$scss->getCachedFileMtime($viewName)).'"';

    header('ETag: '.$etag);

    $timestamp = filemtime($scss->getCachedFileName($viewName));
    header('Last-Modified: '.gmdate('D, d M Y H:i:s ', $timestamp).'GMT');

    if (isClientCachingDocument($etag)) {
        throw new \CachedInClientException();
    }

    echo $data;

} catch (\CachedInClientException $ex) {

    $this->setHttpResponseCode(304); // Not Modified

} catch (\Exception $ex) {

    $this->setHttpResponseCode(400); // Bad Request
    header('Content-Type: application/json');
    echo \Core3\Api\ResponseError::exceptionToJson($ex);
}
