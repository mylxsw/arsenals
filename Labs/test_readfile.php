<?php


$file = file("test.ts");
foreach($file as &$line){
	$doc_pos = strpos($line, '#');
	$content = trim(substr($line, 0, $doc_pos === false ? strlen($line) : $doc_pos));
	if($content != ''){
		echo $content . "\n";
	}
}