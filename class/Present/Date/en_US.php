<?php
namespace Present\Date;

/**
 * English (American)
 */
class en_US extends \Present\Date
{
    /**
     * mm/dd/yyyy
     */
    public function render()
    {
        return date('m/d/Y', $this->ts);
    }
}
