<?php
namespace Present\DateTime;

/**
 * English (American)
 */
class en_US extends \Present\DateTime
{
    /**
     * mm/dd/yyyy
     */
    public function render()
    {
        return date('m/d/Y h:i:s A', $this->ts);
    }
}
