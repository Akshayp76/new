<?php
//image.php
session_start();
#$random_alpha = md5(rand());
#$captcha_code = substr($random_alpha, 0, 6);
/*
$arr = array("dog", "cat", "cow", "sheep", "lion", "tiger", "monkey", "donkey", "hibiscus", "tulip", "rose", "lotus", "sunflower", "apple", "lemon", "orange", "fig", "grapes", "banana", "kiwi", "peach", "potato", "spinach", "mushroom", "cabbage", "beetroot", "corn", "carrot", "plum", "apricot", "broccoli", "cauliflower", "olive", "sun", "moon", "venus", "mercury", "earth", "mars", "jupiter", "saturn", "uranus", "neptune", "january", "february", "march", "april", "may", "june", "july", "september", "october", "november", "december", "sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "is", "are", "was", "were", "will", "animal", "flower", "fruit", "flower", "planet", "month");
#$index = array_rand($arr);
$stmt = "";
for($i = 0; $i < 7; $i++){
    $index = array_rand($arr);
    $stmt = $stmt.".\n".$arr[$index];
}
$_SESSION['stmt'] = $stmt;
 */
if(isset($_GET["val"])) {
  $stmt = $_GET["val"];
} else {
  $stmt = $_SESSION['stmt'];
}
header('Content-Type: image/png');
/*$image = imagecreatetruecolor(200, 300);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 200, 300, $background_color);*/

if(isset($_SESSION['lang']) && $_SESSION['lang'] = 'mr') {
  $font = dirname(__FILE__) . '/../../assets/fonts/Hind-Bold.ttf';
} else {
  $randomNumber = rand(0,34); 
  $font = dirname(__FILE__) . '/../../assets/fonts/font' . $randomNumber . '.ttf';
}


//this works in Windows systems
//$font = dirname(__FILE__) . '/../../assets/fonts/arial.ttf';

//this works in linux systems
#$font = '../../assets/fonts/arial.ttf';
/*for ($x = 1; $x <= 200; $x++){
    $x1 = rand(0, 500);
    $y1 = rand(0, 500);
    $x2 = rand(0, 500);
    $y2 = rand(0, 500);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}*/

$randomBgColor = rand(0,1);
if($randomNumber == 0)
    $randomNumberForBg = rand(1,6); 
else
    $randomNumberForBg = rand(1,16);

$imgfile = dirname(__FILE__) . '/../../assets/backgrounds/'.$randomBgColor.'/'.$randomNumberForBg.'.png';
list($width, $height) = getimagesize($imgfile);
$img1= imagecreatetruecolor(300, 400);
$img = imagecreatefrompng($imgfile);
imagecopyresized($img1, $img, 0, 0, 0, 0, 300, 400, $width, $height);
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
for ($x = 1; $x <= 200; $x++){
    $x1 = rand(0, 500);
    $y1 = rand(0, 500);
    $x2 = rand(0, 500);
    $y2 = rand(0, 500);
    imageline($img1, $x1, $y1, $x2, $y2, $text_color);
}

imagettftext($img1, 30, 0, 60, 70, $text_color, $font, $stmt);
imagepng($img1);
imagedestroy($img1);
?>
