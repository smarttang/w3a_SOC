<?php
require('chinese.php');

$pdf=new PDF_Chinese();
$pdf->AddBig5Font();
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont('GB','',20);
$pdf->Write(10,'中华人民共和国');
$pdf->Output();
?>
