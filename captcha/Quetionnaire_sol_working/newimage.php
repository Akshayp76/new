<?php
//image.php
session_start();

$arr = array("Identify the animal.\n1) Elephant.\n2) Hibiscus.\n3) Earth.\n4) Sun."  => 'elephant', "Identify the animal.\n1) Dog.\n2) China.\n3) Banana.\n4) Apple. " => 'dog', "Identify the animal.\n1) Mango.\n2) Apple.\n3) Cat.\n4) Peach. " => 'cat', "Identify the animal.\n1) Mars.\n2) Dog.\n3) Earth.\n4) Sun. " => 'dog', "Identify the animal.\n1) Cat.\n2) Banana.\n3) Earth.\n4) Sun. " => 'cat', "Identify the flower.\n1) Dog.\n2) Lotus.\n3) Banana.\n4) Apple. " => 'lotus', "Identify the flower.\n1) Mango.\n2) Apple.\n3) Rose.\n4) Peach. " => 'rose',"Identify the planet.\n1) Dog.\n2) China.\n3) Banana.\n4) Earth. " => 'earth' , "Identify the day.\n1) Sunday.\n2) China.\n3) Banana.\n4) Apple. " => 'sunday', "Identify the month.\n1) Elephant.\n2) December.\n3) Earth.\n4) Sun. " => 'december');


$index = array_rand($arr);
$captcha_code = $index;

$_SESSION['cap'] = $captcha_code;

header('Content-Type: image/png');
$image = imagecreatetruecolor(500, 300);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 500, 300, $background_color);
$font = dirname(__FILE__) . '/arial.ttf';
for ($x = 1; $x <= 300; $x++){
    $x1 = rand(0, 500);
    $y1 = rand(0, 500);
    $x2 = rand(0, 500);
    $y2 = rand(0, 500);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}
imagettftext($image, 20, 0, 60, 28, $text_color, $font, $captcha_code);
imagepng($image);
imagedestroy($image);
?>