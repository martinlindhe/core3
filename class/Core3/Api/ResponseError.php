<?php
namespace Core3\Api;

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

        return \Core3\Writer\Json::encodeSlim($arr);
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
        return \Core3\Writer\Json::encodeSlim(self::asArray($code, $message));
    }
}
