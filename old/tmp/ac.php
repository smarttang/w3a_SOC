<?php
class word
{
function start()
{
	ob_start();
	echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
	xmlns:w="urn:schemas-microsoft-com:office:word"
	xmlns="http://www.w3.org/TR/REC-html40">';
}
function save($path)
{
 
echo "</html>";
$data = ob_get_contents();
ob_end_clean();
 
$this->wirtefile ($path,$data);
}
 
function wirtefile ($fn,$data)
{
$fp=fopen($fn,"wb");
fwrite($fp,$data);
fclose($fp);
}
}
$html = file_get_contents("http://localhost/bakup/index2.html");
 
//批量生成
    $word = new word();
    $word->start();
    $wordname = "报告.doc";
    echo $html;
    $word->save($wordname);
    ob_flush();//每次执行前刷新缓存
    flush();
    echo "OK!";
?>
