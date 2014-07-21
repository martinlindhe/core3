<?php
namespace Present\DateTime;

/**
 * English (American)
 */
class en_US extends \Present\DateTime
{
    public function render()
    {
        return date('Y-m-d H:i:s', $this->ts); // FIXME wrong format
    }
}
