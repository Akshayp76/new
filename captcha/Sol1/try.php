<?php
//image.php
session_start();
#$random_alpha = md5(rand());
#$captcha_code = substr($random_alpha, 0, 6);
#$arr = array("Identify the animal:\n1. Elephant\n2. Hibiscus\n3. Earth\n4. Sun"  => 'elephant', "Identify the animal:\n1. Dog\n2. China\n3. Banana\n4. Apple " => 'dog', "Identify the animal:\n1. Mango\n2. Apple\n3. Cat\n4. Peach " => 'cat', "Identify the animal:\n1. Mars\n2. Dog\n3. Earth\n4. Sun " => 'dog', "Identify the animal:\n1. Cat\n2. Banana\n3. Earth\n4. Sun " => 'cat', "Identify the flowers:\n1. Dog\n2. Lotus\n3. Banana\n4. Apple " => 'lotus', "Identify the animal:\n1. Mango\n2. Apple\n3. Rose\n4. Peach " => 'rose',"Identify the planets:\n1. Dog\n2. China\n3. Banana\n4. Earth " => 'earth' , "Identify the days:\n1. Sunday\n2. China\n3. Banana\n4. Apple " => 'sunday', "Identify the months:\n1. Elephant\n2. December\n3. Earth\n4. Sun " => 'december');
$arr = array("Identify the animal:\n1. Elephant\n2. Hibiscus\n3. Earth\n4. Sun"  => 'elephant', "Identify the animal:\n1. Dog\n2. China\n3. Banana\n4. Apple " => 'dog', "Identify the animal:\n1. Mango\n2. Apple\n3. Cat\n4. Peach " => 'cat', "Identify the animal:\n1. Mars\n2. Dog\n3. Earth\n4. Sun " => 'dog', "Identify the animal:\n1. Cat\n2. Banana\n3. Earth\n4. Sun " => 'cat', "Identify the flowers:\n1. Dog\n2. Lotus\n3. Banana\n4. Apple " => 'lotus', "Identify the animal:\n1. Mango\n2. Apple\n3. Rose\n4. Peach " => 'rose',"Identify the planets:\n1. Dog\n2. China\n3. Banana\n4. Earth " => 'earth' , "Identify the days:\n1. Sunday\n2. China\n3. Banana\n4. Apple " => 'sunday', "Identify the months:\n1. Elephant\n2. December\n3. Earth\n4. Sun " => 'december');


$index = array_rand($arr);
$captcha_code = $index;

echo "Hello\n".$captcha_code;
?>