<?php
namespace Present\Date;

/**
 * German
 */
class de_DE extends \Present\Date
{
    public function render()
    {
        return date('Y-m-d', $this->ts);
    }
}
