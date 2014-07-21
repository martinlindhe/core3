<?php
namespace Present\DateTime;

/**
 * Swedish
 */
class sv_SE extends \Present\DateTime
{
    public function render()
    {
        return date('Y-m-d H:i:s', $this->ts);
    }
}
