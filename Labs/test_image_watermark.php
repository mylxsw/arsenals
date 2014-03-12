<?php

require "../Arsenals/Libraries/Images/ImageUtils.php";
use \Arsenals\Libraries\Images\ImageUtils;

$filename = 'test.jpg';

ImageUtils::watermark(array(
	'source_file' => $filename, 
	'watermark'=> 'test.gif', 
	'pos_x'=>-500, 
	'pos_y'=>-444
));


function D($str){
	echo "<pre>";
	var_dump($str);
	echo "</pre>";
}