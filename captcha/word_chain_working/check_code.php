<?php

//check_code.php

session_start();

$code = $_POST['code'];
$yes = $_SESSION['yes'];
$no = $_SESSION['no'];
$cap = $_SESSION['cap'];
$stmt = $_SESSION['stmt'];
$rslt = "";
/*echo "seee this";
echo $yes;
echo $no;
echo "wwoooe";
echo $stmt;
echo "end hrer";*/
//console.log("came hereeeeeeeeee")
//console.log($stmt)
//console.lgo($cap)
if(strpos($stmt, $cap) == true){

    $rslt = $yes;

} else{

    $rslt = $no;

}

//echo "final";
//echo $rslt;
if($code == $rslt)
{
 echo 'success';
}
else
{
    echo "failure";
}

?>
