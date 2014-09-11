<?php
namespace Core3\Present\DateTime;

/**
 * German
 */
class de_DE extends \Core3\Present\DateTime
{
    public function render()
    {
        return date('Y-m-d H:i:s', $this->ts);
    }
}
