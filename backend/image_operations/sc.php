<?php

//image.php

session_start();
$captcha_code = $_SESSION['code'];
header('Content-Type: image/png');
$image = imagecreatetruecolor(200, 38);
$background_color = imagecolorallocate($image, 231, 100, 18);
$text_color = imagecolorallocate($image, 255, 255, 255);
imagefilledrectangle($image, 0, 0, 200, 38, $background_color);

//this works in Windows systems
if(isset($_SESSION['lang']) && $_SESSION['lang'] = 'mr') {
  $font = dirname(__FILE__) . '/../../assets/fonts/Hind-Bold.ttf';
} else {
  $randomNumber = rand(0,34); 
  $font = dirname(__FILE__) . '/../../assets/fonts/font' . $randomNumber . '.ttf';
}

//this works in linux systems
//$font = '../../assets/fonts/arial.ttf';

imagettftext($image, 20, 0, 60, 28, $text_color, $font, $captcha_code);
imagepng($image);
imagedestroy($image);
$parts = array();

/*
for($i = 0; $i < strlen($captcha_code); $i++)
    $parts[] = $c[$i] . '.wav';

exec(sprintf('sox %s -t .wav - | lame - %s.mp3', join(' ', $parts), $c));

header('Content-type: audio/mpeg');
header('Content-length: '.filesize("{$c}.mp3"));
header('Content-disposition: attachment; name="'.$c.'.mp3"');
passthru("{$c}.mp3");
*/

?>

