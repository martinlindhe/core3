<?php
namespace Present\DateTime;

/**
 * German
 */
class de_DE extends \Present\DateTime
{
    public function render()
    {
        return date('Y-m-d H:i:s', $this->ts);
    }
}
