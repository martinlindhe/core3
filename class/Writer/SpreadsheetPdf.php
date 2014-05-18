<?php
/**
 * @author Martin Lindhe <martin.lindhe@freespee.com>
 */

// NOTE: tcpdf supports HTML to PDF, which is required
// NOTE: tcpdf is a set of PHP classes (slow)
// NOTE: the libharu pdf writer (pecl haru) does not support render html

class Writer_SpreadsheetPdf
{
    private function initTcpdfObject()
    {
        $tcpdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        //$tcpdf->SetCreator(PDF_CREATOR);
        //$tcpdf->SetAuthor('Author Name');
        //$tcpdf->SetTitle('Document title');
        //$tcpdf->SetSubject('Document subject');
        //$tcpdf->SetKeywords('comma, separated, keywords');

        // set default header data
        //$tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

        // set image scale factor
        //$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set margins
        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        return $tcpdf;
    }

    /**
     * @return binary PDF document
     */
    public function render(Model_Spreadsheet $model)
    {
        $pdf = $this->initTcpdfObject();

        // add a page
        $pdf->AddPage();

        // TODO how to embed a image in the html?

        $html = '<h1>HTML Example åäö unicode é va!</h1>Repåårt<br/><br/><br/>höjj';

        // TODO use Writer_SpreadsheetHtml to create a html report, attach to pdf!

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('', 'S');
    }
}
