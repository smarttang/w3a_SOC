<?
require('html2fpdf.php');

$pdf=new HTML2FPDF();
$pdf->AddGBFont('GB','GB2312');
$pdf->AddPage();
$fp = fopen("../../index2.html","r");
$html = fread($fp, filesize("../../index2.html"));
fclose($fp);
$pdf->WriteHTML(iconv("UTF-8","GB2312",$html));
ob_clean();
$pdf->Output("tmp.pdf",true);

//echo "PDF file is generated successfully!";
?>
