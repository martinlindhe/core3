<?php

class Writer_SpreadsheetXhtml extends Writer_Spreadsheet
{
	private $classname = 'htmlBox';

	public function setClassName($s) { $this->classname = $s; }

	public function render(Model_Spreadsheet $model)
	{
		return
			'<table class="'.$this->classname.'">'.
			$this->renderHeader($model).
			$this->renderBody($model).
			$this->renderFooter($model).
			'</table>';
	}

	private function renderHeader(Model_Spreadsheet $model)
	{
		$html = '<tr>';
		foreach ($model->getColumns() as $col) {
			$html .= '<th>'.$col.'</th>';
		}
		$html .= '</tr>';
		return $html;
	}

	private function renderBody(Model_Spreadsheet $model)
	{
		$html = '';
		foreach ($model->getRows() as $row) 
		{
			$html .= '<tr>';
			foreach ($row as $col) {
				$html .= '<td>'.$col.'</td>';
			}
			$html .= '</tr>';
		}
		return $html;
	}

	private function renderFooter(Model_Spreadsheet $model)
	{
		$footer = $model->getFooter();

		if (!count($footer)) {
			return '';
		}

		$html = '<tr>';		
		$colspan = '';
	
		if (count($model->getColumns()) > count($footer)) {
			$padCnt = count($model->getColumns()) - count($footer) + 1;
			$colspan = ' colspan="'.$padCnt.'"';
			$html .= '<th'.$colspan.'>'.array_shift($footer).'</th>';
		}

		foreach ($footer as $col) {
			$html .= '<th>'.$col.'</th>';
		}

		$html .= '</tr>';

		return $html;
	}
}
