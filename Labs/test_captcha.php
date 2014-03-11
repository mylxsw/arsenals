<?php
require "../Arsenals/Libraries/Images/Captcha.php";

$captcha = new \Arsenals\Libraries\Images\Captcha();
$code = $captcha->generateCode();
$captcha->createImage($code);