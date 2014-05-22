<?php
namespace Writer;

abstract class Spreadsheet
{
    abstract public function render(\Model\Spreadsheet $model);
}
