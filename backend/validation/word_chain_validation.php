<?php

//check_code.php

session_start();

$code = $_POST['code'];
$q_secret = $_SESSION['q_secret_img'];
$word = $q_secret[0]; 
$yes = $q_secret[1];
$no = $q_secret[2];
$stmt = $q_secret[3];
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
if(strpos($stmt, $word) == true){
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
