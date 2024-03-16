<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//check_code.php

session_start();

$img = $_POST['img'];
$inp_num = $_SESSION['answer'];

list($type, $data) = explode(';', $img);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

$post_params['img'] = base64_encode($data);
//$stmt = $_SESSION['stmt'];
$rslt = "";

// Get cURL resource
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => 'http://localhost:5000/numpredict/',
  CURLOPT_USERAGENT => 'Codular Sample cURL Request',
  CURLOPT_POST => 1,
  CURLOPT_POSTFIELDS => $post_params 
]);
#curl_setopt($curl, CURLOPT_HTTPHEADER, array ('Content-Type: application/json'));
$html = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

error_log($html);
error_log('inp');
error_log($inp_num);
$res = $html;

if($res == $inp_num) {
  echo 'success';
} else {
  echo "failure";
}

/*echo "seee this";
echo $yes;
echo $no;
echo "wwoooe";
echo $stmt;
echo "end hrer";*/
//console.log("came hereeeeeeeeee")
//console.log($stmt)
//console.lgo($cap)

//echo "final";
//echo $rslt;
/*
if($code == $rslt)
{
  echo 'success';
}
else
{
  echo "failure";
}
 */

?>
