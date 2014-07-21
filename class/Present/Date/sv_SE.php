<?php
namespace Present\Date;

/**
 * Swedish
 */
class sv_SE extends \Present\Date
{
    public function render()
    {
        return date('Y-m-d', $this->ts);
    }
}
