<?php
namespace Api;

class ResponseError
{
    const GENERAL = 400;
    const MISSING_PARAM = 410;
    const EXCEPTION = 420;

    protected static function getDefaultMessage($code)
    {
        switch ($code) {
        case self::GENERAL:
            return 'General error';
        case self::MISSING_PARAM:
            return 'Missing parameters';
        case self::EXCEPTION:
            return 'Exception';
        }
    }
    
    public static function exceptionToJson(\Exception $ex)
    {
        $arr = array(
            'code'      => self::EXCEPTION,
            'status'    => 'exception',
            'exception' => get_class($ex),
            'message'   => htmlentities($ex->getMessage()),
            'file'      => htmlentities($ex->getFile()),
            'line'      => $ex->getLine(),
        );

        return json_encode($arr, JSON_UNESCAPED_SLASHES);
    }

    public static function asArray($code, $message = '')
    {
        if (!$message) {
            $message = self::getDefaultMessage($code);
        }

        return array('code' => $code, 'message' => $message);
    }

    public static function render($code, $message = '')
    {
        return json_encode(self::asArray($code, $message));
    }
}
