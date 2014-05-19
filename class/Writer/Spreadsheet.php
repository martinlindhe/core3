<?php

/**
 * Base for spreadsheet writer classes
 */
abstract class Writer_Spreadsheet
{
	abstract public function render(Model_Spreadsheet $model);
}

