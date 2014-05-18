<?php
/**
 * @author Martin Lindhe
 */

// TODO require TCPDF

class SpreadsheetModel
{
    var $columns = array();
    var $rows = array();
}

class PdfSpreadsheetWriter
{

    public function render(SpreadsheetModel $model)
    {
    }
}

var $model = new SpreadsheetModel();

$model->columns = array('id', 'name');
$model->rows[] = array('1', 'kalle');
$model->rows[] = array('2', 'olle');

$writer = new PdfSpreadsheetWriter();


echo $writer->render($model);
