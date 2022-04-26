<?php
$doc=new DOMDocument();
$doc->loadHTMLFile("index2.html");
echo $doc->saveHTML("a.doc");
?>
