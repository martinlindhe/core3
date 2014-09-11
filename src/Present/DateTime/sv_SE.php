<?php
namespace Core3\Present\DateTime;

/**
 * Swedish
 */
class sv_SE extends \Core3\Present\DateTime
{
    public function render()
    {
        return date('Y-m-d H:i:s', $this->ts);
    }
}
