<?php
namespace Core3\Present\Date;

/**
 * Swedish
 */
class sv_SE extends \Core3\Present\Date
{
    public function render()
    {
        return date('Y-m-d', $this->ts);
    }
}
