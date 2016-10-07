<?php

require '../Arsenals/Libraries/Images/ImageUtils.php';
use \Arsenals\Libraries\Images\ImageUtils;

$filename = 'test.jpg';

//D(getimagesize($filename));

// ImageUtils::resizePercent($filename, 0.4, "thumb_" . $filename);
ImageUtils::thumb($filename, 400, 200);


function D($str)
{
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
}
