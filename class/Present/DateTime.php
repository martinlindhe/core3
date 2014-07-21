<?php
namespace Present;

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
        $locale = strtolower($locale);
        if ($locale == 'sv_se') {
            return (new DateTime\sv_SE($ts))->render();
        }
        throw new \Exception('unhandled locale '.$locale);
    }
}
