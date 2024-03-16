<?php
//image.php
session_start();

$qbank = array('Identify the animal:\n1. Elephant\n2. Hibiscus\n3. Earth\n4. Sun ' => 'elephant', 'Identify the animal:\n1. Dog\n2. China\n3. Banana\n4. Apple ' => 'dog', 'Identify the animal:\n1. Mango\n2. Apple\n3. Cat\n4. Peach ' => 'cat', 'Identify the animal:\n1. Mars\n2. Dog\n3. Earth\n4. Sun ' => 'dog', 'Identify the animal:\n1. Cat\n2. Banana\n3. Earth\n4. Sun ' => 'cat', 'Identify the flowers:\n1. Dog\n2. Lotus\n3. Banana\n4. Apple ' => 'lotus', 'Identify the animal:\n1. Mango\n2. Apple\n3. Rose\n4. Peach ' => 'rose','Identify the planets:\n1. Dog\n2. China\n3. Banana\n4. Earth ' => 'earth' , 'Identify the days:\n1. Sunday\n2. China\n3. Banana\n4. Apple ' => 'sunday', 'Identify the months:\n1. Elephant\n2. December\n3. Earth\n4. Sun ' => 'december');




#$_SESSION['animals'] = $animals;
#$_SESSION['flowers'] = $flowers;
#$_SESSION['vegetables'] = $vegetables;
#$_SESSION['fruits'] = $fruits;
#$_SESSION['planets'] = $planets;
#$_SESSION['months'] = $months;
#$_SESSION['days'] = $days;
#$index = array_rand($arr);
$stmt = "";
for($i = 0; $i < 7; $i++){
    $index = array_rand($arr);
    $stmt = $stmt.".\n".$arr[$index];
}
$_SESSION['stmt'] = $stmt;
header('Content-Type: image/png');
$image = imagecreatetruecolor(200, 300);
$background_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 200, 300, $background_color);
$font = dirname(__FILE__) . '/arial.ttf';
for ($x = 1; $x <= 200; $x++){
    $x1 = rand(0, 500);
    $y1 = rand(0, 500);
    $x2 = rand(0, 500);
    $y2 = rand(0, 500);
    
    imageline($image, $x1, $y1, $x2, $y2, $text_color);
}
imagettftext($image, 20, 0, 60, 28, $text_color, $font, $stmt);
imagepng($image);
imagedestroy($image);
?>