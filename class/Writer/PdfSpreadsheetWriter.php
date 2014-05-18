<?php
/**
 * @author Martin Lindhe <martin@ubique.se>
 */

class PdfSpreadsheetWriter
{
    private function initTcpdfObject()
    {
        if (!class_exists('TCPDF')) {
            throw new Exception ('tcpdf is missing');
        }

        $tcpdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        //$tcpdf->SetCreator(PDF_CREATOR);
        //$tcpdf->SetAuthor('Author Name');
        //$tcpdf->SetTitle('Document title');
        //$tcpdf->SetSubject('Document subject');
        //$tcpdf->SetKeywords('comma, separated, keywords');

        // set default header data
        //$tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

        // set margins
        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        //$tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        // ## fonts ##
        // set header and footer fonts
        //$tcpdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        //$tcpdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        //$tcpdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set font
        //$tcpdf->SetFont('dejavusans', '', 10);

        return $tcpdf;
    }

    /**
     * @return binary PDF document
     */
    public function render(SpreadsheetModel $model)
    {
        $pdf = $this->initTcpdfObject();

        // add a page
        $pdf->AddPage();

        $html = '<h1>HTML Example åäö unicode é va!</h1>Repåårt<br/><br/><br/>höjj';

        // TODO use HtmlSpreadsheetWriter to create a html report, attach to pdf!


        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('', 'S');
    }
}
