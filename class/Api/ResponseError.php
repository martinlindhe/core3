<?php
namespace Api;

class ResponseError
{
    const GENERAL       = 400;
    const MISSING_PARAM = 410;
    const EXCEPTION     = 420;

    protected static function getDefaultMessage($code)
    {
        $messages = array(
            self::GENERAL       => 'General error',
            self::MISSING_PARAM => 'Missing parameters',
            self::EXCEPTION     => 'Exception',
        );
        return $messages[$code];
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
