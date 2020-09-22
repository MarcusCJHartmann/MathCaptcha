<?php include("MathsCaptcha.class.php");

$cap=new MathsCaptcha();
$cap->init();
echo $cap->getSVGMaths();