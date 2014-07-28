<?php
namespace Core3\Writer;

abstract class Spreadsheet
{
    abstract public function render(\Core3\Model\Spreadsheet $model);
}
