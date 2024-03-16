<?php

//check_code.php

session_start();

$code = $_POST['code'];
#$yes = $_SESSION['yes'];
#$no = $_SESSION['no'];
$cap = $_SESSION['cap'];
#$stmt = $_SESSION['stmt'];
$rslt = "";


$arr = array("Identify the animal.\n1) Elephant.\n2) Hibiscus.\n3) Earth.\n4) Sun."  => 'elephant', "Identify the animal.\n1) Dog.\n2) China.\n3) Banana.\n4) Apple. " => 'dog', "Identify the animal.\n1) Mango.\n2) Apple.\n3) Cat.\n4) Peach. " => 'cat', "Identify the animal.\n1) Mars.\n2) Dog.\n3) Earth.\n4) Sun. " => 'dog', "Identify the animal.\n1) Cat.\n2) Banana.\n3) Earth.\n4) Sun. " => 'cat', "Identify the flower.\n1) Dog.\n2) Lotus.\n3) Banana.\n4) Apple. " => 'lotus', "Identify the flower.\n1) Mango.\n2) Apple.\n3) Rose.\n4) Peach. " => 'rose',"Identify the planet.\n1) Dog.\n2) China.\n3) Banana.\n4) Earth. " => 'earth' , "Identify the day.\n1) Sunday.\n2) China.\n3) Banana.\n4) Apple. " => 'sunday', "Identify the month.\n1) Elephant.\n2) December.\n3) Earth.\n4) Sun. " => 'december');


if(strcasecmp($arr[$cap], $code) == 0){
	echo 'success';	
}

?>
