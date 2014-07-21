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
        $locale = strtolower($locale);
        if ($locale == 'sv_se') {
            return (new Date\sv_SE($ts))->render();
        }
        throw new \Exception('unhandled locale '.$locale);
    }
}
