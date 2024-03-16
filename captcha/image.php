<?php

//image.php

session_start();

$random_alpha = md5(rand());

$captcha_code = substr($random_alpha, 0, 6);

$_SESSION['captcha_code'] = $captcha_code;

header('Content-Type: image/png');

$image = imagecreatetruecolor(200, 38);

$background_color = imagecolorallocate($image, 231, 100, 18);

$text_color = imagecolorallocate($image, 255, 255, 255);

imagefilledrectangle($image, 0, 0, 200, 38, $background_color);

$font = dirname(__FILE__) . '/arial.ttf';

imagettftext($image, 20, 0, 60, 28, $text_color, $font, $captcha_code);


imagepng($image);

imagedestroy($image);
$parts = array();
$c = $_SESSION['captcha_code'];

for($i = 0; $i < strlen($c); $i++)
    $parts[] = $c[$i] . '.wav';

exec(sprintf('sox %s -t .wav - | lame - %s.mp3', join(' ', $parts), $c));

header('Content-type: audio/mpeg');
header('Content-length: '.filesize("{$c}.mp3"));
header('Content-disposition: attachment; name="'.$c.'.mp3"');
passthru("{$c}.mp3");

?>

