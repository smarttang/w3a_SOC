<?php
//============================================================+
// File name   : example_038.php
// Begin       : 2008-09-15
// Last Update : 2011-10-01
//
// Description : Example 038 for TCPDF class
//               CID-0 CJK unembedded font
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: CID-0 CJK unembedded font
 * @author Nicola Asuni
 * @since 2008-09-15
 */

require_once('tcp/tcpdf/config/lang/eng.php');
require_once('tcp/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 038');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 038', PDF_HEADER_STRING);

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

// set font
$pdf->SetFont('cid0jp', '', 10);

// add a page
$pdf->AddPage();

$html=file_get_contents("http://localhost/bakup/sample.html");
//$pdf->Write(0, iconv("UTF-8","UTF-8",$html), '', 0, 'L', true, 0, false, false, 0);
$pdf->writeHTML($html, true, false, true, false, '');
//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', iconv("UTF-8","UTF-8",$html), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);



// ---------------------------------------------------------

//Close and output PDF document //D是下载
$pdf->Output('example_038.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
