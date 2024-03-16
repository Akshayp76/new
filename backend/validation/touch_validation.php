<?php

//check_code.php

session_start();

$num_taps_client = $_POST['code'];
$num_taps_req = $_SESSION['taps'];
$rslt = "";
if($num_taps_client == $num_taps_req)
{
  echo 'success';
}
else
{
  echo "failure";
}

?>
