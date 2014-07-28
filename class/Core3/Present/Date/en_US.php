<?php
namespace Core3\Present\Date;

/**
 * English (American)
 */
class en_US extends \Core3\Present\Date
{
    /**
     * mm/dd/yyyy
     */
    public function render()
    {
        return date('m/d/Y', $this->ts);
    }
}
