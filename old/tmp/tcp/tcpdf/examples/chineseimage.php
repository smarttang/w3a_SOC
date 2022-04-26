<?php
 
require_once('../config/lang/chi.php');
require_once('../tcpdf.php');
 
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('中文');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
 
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 008', PDF_HEADER_STRING);
 
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
$pdf->setLanguageArray($l);
 
// ---------------------------------------------------------
 
// set default font subsetting mode
$pdf->setFontSubsetting(true);
 
// set font
$pdf->SetFont('droidsansfallback', '', 12);
 
// add a page
$pdf->AddPage();
 
// set color for text
$pdf->SetTextColor(0, 63, 127);
 
// write the text
$pdf->Write(5, '中文，你支持么。chinese support', '', 0, '', false, 0, false, false, 0);
 
$pdf->SetXY(40, 40);
$pdf->Image('../images/tcpdf_logo.jpg', '', '', 0, 0, '', '', '', false, 300, '', false, false, 1, false, false, false);
 
 
// ---------------------------------------------------------
 
//Close and output PDF document
$pdf->Output('example_008.pdf', 'I');
 
//============================================================+
// END OF FILE                                                
//============================================================+