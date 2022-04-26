<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_smart{
        public function Pdf_do($config = array())
        {
		$source_name=$config['name'];
		$task_name=$config['output'];
		require('htmlofpdf/html2fpdf.php');

		$pdf=new HTML2FPDF();
		$pdf->AddGBFont('GB','GB2312');
		$pdf->AddPage();
		$fp = fopen($source_name,"r");
		$strContent = fread($fp, filesize($source_name));
		fclose($fp);
		$pdf->WriteHTML(iconv("UTF-8","GB2312",$strContent));
		ob_clean();
		$pdf->Output($task_name,true);
	}
}
/* End of file Someclass.php */
