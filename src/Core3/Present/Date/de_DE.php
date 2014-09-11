<?php
namespace Core3\Present\Date;

/**
 * German
 */
class de_DE extends \Core3\Present\Date
{
    public function render()
    {
        return date('Y-m-d', $this->ts);
    }
}
