<?php
require_once('tcp/tcpdf/config/lang/chi.php');
require_once('tcp/tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Set font
        $this->SetFont('stsongstdlight', 'B', 12);
        // Title
        $this->SetY(15);
        $this->Cell(0, 15, PDF_HEADER_TITLE, 0, false, 'C', 0, '', 0, false, 'B', 'B');
        $this->Cell(0, 15, PDF_HEADER_STRING, 0, false, 'R', 0, '', 0, false, 'B', 'B');
        // print an ending header line
        $headerdata = $this->getHeaderData();
        $imgy = $this->getImageRBY();
        $this->SetLineStyle(array('width' => 0.85 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => $headerdata['line_color']));
        $this->SetY((2.835 / $this->k),max($imgy, $this->y));
        if ($this->rtl) {
            $this->SetX($this->original_rMargin);
        } else {
            $this->SetX($this->original_lMargin);
        }
        $this->Cell(($this->w - $this->original_lMargin - $this->original_rMargin), 0, '', 'T', 0, 'C');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle(PDF_HEADER_TITLE);
$pdf->SetSubject(PDF_HEADER_TITLE);
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray('cn');

// set font
//$pdf->SetFont('droidsansfallback', '', 10);
$pdf->SetFont('cid0jp', '', 10);

// add a page
$pdf->AddPage();

$html = file_get_contents("http://localhost/bakup/index2.html");

$pdf->SetY(15);
// output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->SetCellPadding(0);

$pdf->lastPage();

$pdf->Output('test.pdf', 'I');
