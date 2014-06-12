<?php

namespace Writer\Spreadsheet;

class Json extends \Writer\Spreadsheet
{
    public function render(\Model\Spreadsheet $model)
    {
        return \Writer\Json::encodeSlim($model->getRows());
    }
}
