<?php

namespace Core3\Writer\Spreadsheet;

class Json extends \Core3\Writer\Spreadsheet
{
    public function render(\Core3\Model\Spreadsheet $model)
    {
        return \Core3\Writer\Json::encodeSlim($model->getRows());
    }
}
