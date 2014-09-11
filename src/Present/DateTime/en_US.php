<?php
namespace Core3\Present\DateTime;

/**
 * English (American)
 */
class en_US extends \Core3\Present\DateTime
{
    /**
     * mm/dd/yyyy
     */
    public function render()
    {
        return date('m/d/Y h:i:s A', $this->ts);
    }
}
