<?php

//check_code.php

session_start();

$code = $_POST['code'];
$yes = $_SESSION['yes'];
$no = $_SESSION['no'];
$cap = $_SESSION['cap'];
$stmt = $_SESSION['stmt'];
$rslt = "";
if(strpos($stmt, $cap) == true){

    $rslt = $yes;

} else{

    $rslt = $no;

}

if(strcasecmp($code, $rslt) == 0)
{
 echo 'success';
}

?>