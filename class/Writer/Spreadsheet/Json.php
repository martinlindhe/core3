<?php

namespace Writer\Spreadsheet;

class Json extends \Writer\Spreadsheet
{
    public function render(\Model\Spreadsheet $model)
    {
        return json_encode($model->getRows(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
