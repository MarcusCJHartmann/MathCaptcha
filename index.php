<?php include("MathsCaptcha.class.php");

if($_REQUEST&&$_REQUEST["_captcha_solution"]&&$_REQUEST["_captcha_hash"]){
    var_dump(MathsCaptcha::verify($_REQUEST["_captcha_solution"],$_REQUEST["_captcha_hash"]));
}
?>

<form>
<?php
$cap=new MathsCaptcha();
$cap->getCaptcha();
?>
<button type="submit">Absenden</button>
</form>
