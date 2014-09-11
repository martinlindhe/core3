<?php
namespace Core3\Present;

class DateTime
{
    protected $ts = 0;

    /**
     * @param $ts unix timestamp
     */
    public function __construct($ts = 0)
    {
        $this->setTimestamp($ts);
    }

    public function setTimestamp($ts)
    {
        if (!is_integer($ts)) {
            throw new \Exception('bad input');
        }
        $this->ts = $ts;
    }

    /**
     * ISO 8601 datetime
     */
    public function render()
    {
        return date('c', $this->ts);
    }

    /**
     * @return string local representation of date
     */
    public static function localized($locale, $ts = 0)
    {
        if (!in_array($locale, array('sv_SE', 'en_US', 'de_DE'))) {
            throw new \Exception('unhandled locale '.$locale);
        }

        $class = __CLASS__.'\\'.$locale;
        return (new $class($ts))->render();
    }

}
