<?php
//image.php
session_start();
#$random_alpha = md5(rand());
#$captcha_code = substr($random_alpha, 0, 6);
$word = $_SESSION['word'];

/* change language of text */

header('Content-Type: image/png');
/*$image = imagecreatetruecolor(200, 38);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 200, 38, $background_color);
*/
//this works in Windows systems
/* $font = dirname(__FILE__) . '/../../assets/fonts/arial.ttf';*/
//$font = dirname(__FILE__) . '/../../assets/fonts/arial.ttf';

if(isset($_SESSION['lang']) && $_SESSION['lang'] = 'mr') {
  $font = dirname(__FILE__) . '/../../assets/fonts/Hind-Bold.ttf';
} else {
  $randomNumber = rand(0,34); 
  $font = dirname(__FILE__) . '/../../assets/fonts/font' . $randomNumber . '.ttf';
}
/*
$randomNumber = rand(0,34); 
$font = dirname(__FILE__) . '/../../assets/fonts/font' . $randomNumber . '.ttf';
 */

//this works in linux systems
//$font = '../../assets/fonts/arial.ttf';

/*for ($x = 1; $x <= 200; $x++){
    $x1 = rand(0, 200);
    $y1 = rand(0, 200);
    $x2 = rand(0, 200);
    $y2 = rand(0, 200);
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}*/

$randomBgColor = rand(0,1);
if(isset($randomNumber) && $randomNumber == 0)
    $randomNumberForBg = rand(1,6); 
else
    $randomNumberForBg = rand(1,16);

$imgfile = dirname(__FILE__) . '/../../assets/backgrounds/'.$randomBgColor.'/'.$randomNumberForBg.'.png';
list($width, $height) = getimagesize($imgfile);
$img1= imagecreatetruecolor(200, 48);
$img = imagecreatefrompng($imgfile);
imagecopyresized($img1, $img, 0, 0, 0, 0, 200, 48, $width, $height);
if($randomBgColor == 0){
    $randomTextColor = rand(1, 2);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img1, 250, 250, 200); #cream
    else 
        $text_color = imagecolorallocate($img1, 255, 255, 0);  #yellow


}
else{
    $randomTextColor = rand(1, 4);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img1, 0, 0, 0); #black
    else if($randomTextColor == 2)
        $text_color = imagecolorallocate($img1, 0, 0, 102); #blue
    else if($randomTextColor == 3)
        $text_color = imagecolorallocate($img1, 122, 31, 31); #brown
    else
        $text_color = imagecolorallocate($img1, 41, 10, 10); #dark brown
    
}

imagettftext($img1, 30, 0, 20, 28, $text_color, $font, $word);
imagepng($img1);
imagedestroy($img1);
?>
