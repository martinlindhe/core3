<?php

class Writer_Spreadsheet_Pdf
{
    protected $creator;
    protected $author;
    protected $title;
    protected $subject;
    protected $keywords = array();

    protected $htmlStart;
    protected $htmlEnd;

    public function setStartHtmlBlock($s)
    {
        $this->htmlStart = $s;
    }

    public function setEndHtmlBlock($s)
    {
        $this->htmlEnd = $s;
    }

    public function setCreator($s)
    {
        $this->creator = $s;
    }

    public function setAuthor($s)
    {
        $this->author = $s;
    }

    public function setTitle($s)
    {
        $this->title = $s;
    }

    public function setSubject($s)
    {
        $this->subject = $s;
    }

    public function addKeyword($s)
    {
        $this->keywords[] = $s;
    }

    /**
	 * @param $a array
	 */
    public function addKeywords($a)
    {
        foreach ($a as $word) {
            $this->addKeyword($word);
        }
    }

    public function sendHttpAttachmentHeaders($fileName)
    {
        $header = new Writer_HttpHeader();
        $header->sendContentType('application/pdf');
        $header->sendAttachment($fileName);
        $header->sendNoCacheHeaders();
    }

    private function initTcpdfObject()
    {
        $tcpdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        if ($this->creator) {
            $tcpdf->SetCreator($this->creator);
        }

        if ($this->author) {
            $tcpdf->SetAuthor($this->author);
        }

        if ($this->title) {
            $tcpdf->SetTitle($this->title);
        }

        if ($this->subject) {
            $tcpdf->SetSubject($this->subject);
        }

        if (!empty($this->keywords)) {
            $tcpdf->SetKeywords(implode(', ', $this->keywords));
        }

        // set default header data
        //$tcpdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);


        // document defaults
        $tcpdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $tcpdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $tcpdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $tcpdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $tcpdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        return $tcpdf;
    }

    /**
	 * @return binary PDF document
	 */
    public function render(Model_Spreadsheet $model)
    {
        $pdf = $this->initTcpdfObject();

        $pdf->AddPage();

        $writer = new Writer_Spreadsheet_Xhtml();

        $html =
            $this->htmlStart.
            $writer->render($model).
            $this->htmlEnd;

        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('', 'S');
    }
}