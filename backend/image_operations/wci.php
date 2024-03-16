<?php

//image.php

session_start();

#$random_alpha = md5(rand());

#$random_alpha = substr(md5(microtime()),rand(0,26),1);

/*
$seed = str_split('abcdefghijklmnopqrstuvwxyz'); // and any other characters
shuffle($seed); // probably optional since array_is randomized; this may be redundant
$no = $seed[0];

#$captcha_code = substr($random_alpha, 0, 6);

$_SESSION['no'] = $no;
*/
$no = $_SESSION['no'];

header('Content-Type: image/png');

/*$image = imagecreatetruecolor(130, 38);

$background_color = imagecolorallocate($image, 255, 255, 255);

$text_color = imagecolorallocate($image, 0, 0, 0);

imagefilledrectangle($image, 0, 0, 130, 38, $background_color);*/

//this works in Windows systems
//$font = dirname(__FILE__) . '/../../assets/fonts/arial.ttf';

$randomNumber = rand(0,34); 
$font = dirname(__FILE__) . '/../../assets/fonts/font'.$randomNumber.'.ttf';

//this works in linux systems
//$font = '../../assets/fonts/arial.ttf';

/*for ($x = 1; $x <= 50; $x++){
    $x1 = rand(0, 130);
    $y1 = rand(0, 130);
    $x2 = rand(0, 130);
    $y2 = rand(0, 130);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}*/


$randomBgColor = rand(0,1);
if($randomNumber == 0)
    $randomNumberForBg = rand(1,6); 
else
    $randomNumberForBg = rand(1,16);

$imgfile = dirname(__FILE__) . '/../../assets/backgrounds/'.$randomBgColor.'/'.$randomNumberForBg.'.png';
list($width, $height) = getimagesize($imgfile);
$img1= imagecreatetruecolor(130, 38);
$img = imagecreatefrompng($imgfile);
imagecopyresized($img1, $img, 0, 0, 0, 0, 130, 38, $width, $height);
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



imagettftext($img1, 30, 0, 50, 28, $text_color, $font, $no);

imagepng($img1);

imagedestroy($img1);

?>
