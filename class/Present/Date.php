<?php
namespace Present;

class Date extends DateTime
{
    /**
     * ISO 8601 date
     */
    public function render()
    {
        return date('Y-m-d', $this->ts);
    }

    public static function localized($locale, $ts = 0)
    {
        if (!in_array($locale, array('sv_SE', 'en_US', 'de_DE'))) {
            throw new \Exception('unhandled locale '.$locale);
        }

        $class = __CLASS__.'\\'.$locale;
        return (new $class($ts))->render();
    }
}
