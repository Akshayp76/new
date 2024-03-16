<?php
//image.php
session_start();
#$random_alpha = md5(rand());
#$captcha_code = substr($random_alpha, 0, 6);
$arr = array("dog", "cat", "cow", "sheep", "lion", "tiger", "monkey", "donkey", "hibiscus", "tulip", "rose", "lotus", "sunflower", "apple", "lemon", "orange", "fig", "grapes", "banana", "kiwi", "peach", "potato", "spinach", "mushroom", "cabbage", "beetroot", "corn", "carrot", "plum", "apricot", "broccoli", "cauliflower", "olive", "sun", "moon", "venus", "mercury", "earth", "mars", "jupiter", "saturn", "uranus", "neptune", "january", "february", "march", "april", "may", "june", "july", "september", "october", "november", "december", "sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "is", "are", "was", "were", "will", "animal", "flower", "fruit", "flower", "planet", "month");
$index = array_rand($arr);
$cap = $arr[$index];
$_SESSION['cap'] = $cap;
header('Content-Type: image/png');
$image = imagecreatetruecolor(200, 38);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 200, 38, $background_color);
$font = dirname(__FILE__) . '/arial.ttf';
for ($x = 1; $x <= 200; $x++){
    $x1 = rand(0, 200);
    $y1 = rand(0, 200);
    $x2 = rand(0, 200);
    $y2 = rand(0, 200);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}
imagettftext($image, 20, 0, 60, 28, $text_color, $font, $cap);
imagepng($image);
imagedestroy($image);
?>
