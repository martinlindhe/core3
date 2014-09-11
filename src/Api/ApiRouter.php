<?php
namespace Core3\Api;

/**
 * Maps api request type to corresponding class method
 */
class ApiRouter extends \Core3\Web\RequestRouter
{
    /**
     * Converts requested view name to CamelCase class name,
     * for example: get-all-files => GetAllFiles
     */
    public static function convertToCamelCase($viewName)
    {
        // TODO unit test
        $res = '';
        foreach (explode('-', $viewName) as $word) {
            $res .= ucfirst($word);
        }
        return $res;
    }

    public function routeView($viewName, array $param, $requestMethod)
    {
        $viewClassName = self::convertToCamelCase($viewName);

        // first, look in app/api/routname.php
        $apiViewFileName = $this->applicationDirectoryRoot.'/api/'.$viewClassName.'.php';
        if (!file_exists($apiViewFileName)) {
            // next, look in core3/api/routename.php
            $apiViewFileName = __DIR__.'/../../../api/'.$viewClassName.'.php';
            if (!file_exists($apiViewFileName)) {
                $this->setHttpResponseCode(400); // Bad Request
                echo \Core3\Writer\Json::encodeSlim(array('error' => 'route not available'));
                return;
            }
        }

        try {
            // TODO use camel case file names too
            include $apiViewFileName;

            $apiClass = new $viewClassName();

            $requestMapping = array(
                'GET' => 'handleGet',
                'POST' => 'handlePost',
                'PUT' => 'handlePut',
                'DELETE' => 'handleDelete'
            );

            foreach ($requestMapping as $availableRequestMethod => $handleMethod) {
                if ($requestMethod == $availableRequestMethod) {
                    if (method_exists($apiClass, $handleMethod)) {
                        include $this->applicationDirectoryRoot.'/settings/database.php';

                        $apiClass->$handleMethod($param, $db);
                        return;
                    } else {
                        throw new \Exception($requestMethod.' not available');
                    }
                }
            }

            throw new \Exception('no methods available on '.$viewName.' resource');

        } catch (\Core3\Exception\FileNotFound $ex) {
            $this->setHttpResponseCode(404); // File Not Found
            echo \Core3\Api\ResponseError::exceptionToJson($ex);
        } catch (\Exception $ex) {
            $this->setHttpResponseCode(400); // Bad Request
            echo \Core3\Api\ResponseError::exceptionToJson($ex);
        }
    }
}
