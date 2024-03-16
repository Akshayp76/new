<?php
//image.php
require '../config.php';
session_start();
//$captcha_code = $index;
//
$q_secret = $_SESSION['q_secret_img'];
if(isset($_SESSION['shape'])) {
  $question = $_SESSION['shape'];
} elseif(isset($_SESSION['pressure_id'])) {
  $question = $_SESSION['pressure_id'];
}
else {
  $question = $_SESSION['question'];
}

if(isset($_GET['id'])) {
  $img_id = $_GET['id'];
  $question = $q_secret[$img_id];
  $num_of_newlines = substr_count($question, "\n") + 1;
  error_log($question);
}

if(isset($_GET['height'])) {
  $img_height = $_GET['height'];
}

if(isset($_GET['width'])) {
  $img_width = $_GET['width'];
}

/*
$q_string = $_SESSION['q_string'];
$q_secret = $_SESSION['q_secret'];

$txt = str_replace("|", $q_secret, $q_string);
 */

/* Create the image. */
/*$image = imagecreatetruecolor(500, 300);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 500, 300, $background_color);
//$font = dirname(__FILE__) . '/../../assets/fonts/arial.ttf';
/*for ($x = 1; $x <= 300; $x++){
    $x1 = rand(0, 500);
    $y1 = rand(0, 500);
    $x2 = rand(0, 500);
    $y2 = rand(0, 500);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}*/
/*$giffile = dirname(__FILE__) . '/../../assets/fonts/1.gif';
if(!$giffile)
    {
        /* Create a blank image */
        /*$im = imagecreatetruecolor (150, 30);
        $bgc = imagecolorallocate ($im, 255, 255, 255);
        $tc = imagecolorallocate ($im, 0, 0, 0);

        imagefilledrectangle ($im, 0, 0, 150, 30, $bgc);*/

        /* Output an error message */
        /*imagestring ($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

$image = imagecreatefromgif($giffile);
$imgResized = imagescale($image , 200, 400);*/
if(isset($_SESSION['lang']) && $_SESSION['lang'] = 'mr') {
  $font = dirname(__FILE__) . '/../../assets/fonts/Hind-Bold.ttf';
} else {
  $randomNumber = rand(0,95); 
  $font = dirname(__FILE__) . '/../../assets/fonts/font' . $randomNumber . '.ttf';
}

$randomBgColor = rand(0,1);
$randomNumberForBg = rand(1,20); 


$imgfile = dirname(__FILE__) . '/../../assets/backgrounds/'.$randomBgColor.'/'.$randomNumberForBg.'.png';
$img = imagecreatefrompng($imgfile);
$cropping_rect = ['x' => 0,
                  'y' => 0,
                  'width' => $img_width,
                  'height' => $img_height
                ];
$img = imagecrop($img, $cropping_rect );

if($randomBgColor == 0){
    $randomTextColor = rand(1, 2);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img, 250, 250, 200); #cream
    else 
        $text_color = imagecolorallocate($img, 255, 255, 0);  #yellow
} 
else if($randomBgColor == 1){
    $randomTextColor = rand(1, 4);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img, 0, 0, 0); #black
    else if($randomTextColor == 2)
        $text_color = imagecolorallocate($img, 0, 0, 102); #blue
    else if($randomTextColor == 3)
        $text_color = imagecolorallocate($img, 122, 31, 31); #brown
    else
        $text_color = imagecolorallocate($img, 41, 10, 10); #dark brown
}
else if($randomBgColor == 2){
    $randomTextColor = rand(1, 2);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img, 0, 0, 0); #black
    else 
        $text_color = imagecolorallocate($img, 0, 0, 102); #blue
}
else if($randomBgColor == 3){
    $randomTextColor = rand(1, 3);
    if($randomTextColor == 1)
        $text_color = imagecolorallocate($img, 250, 250, 200); #cream
    else if($randomTextColor == 2)
        $text_color = imagecolorallocate($img, 213, 93, 93); #light brown 
    else if($randomTextColor == 3)
        $text_color = imagecolorallocate($img, 255, 255, 128); #light yellow rgb(255, 255, 128) 


}

// Decide no of lines to draw depending on the area
for ($x = 1; $x <= ($img_width * $img_height / 700); $x++){
    $x1 = rand(0, $img_width);
    $y1 = rand(0, $img_height);
    $x2 = rand(0, $img_width);
    $y2 = rand(0, $img_height);
    $x3 = rand(0, $img_width);
    $y3 = rand(0, $img_height);

    $randomShape = rand(1, 3);
    if($randomShape == 1)
      imageline($img, $x1, $y1, $x2, $y2, $text_color);
    else if($randomShape == 2)
      imagerectangle($img, $x1, $y1, $x2, $y2, $text_color);
    else if($randomShape == 3)
      imagearc($img, $x1, $y1, $x2, $y2, $x3, $y3, $text_color);
}

imagettftext($img, 30, 0, 50, $img_height/$num_of_newlines , $text_color, $font, $question);
imagepng($img);
imagedestroy($img);

?>
