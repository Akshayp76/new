<?php

//check_code.php

session_start();

$code_client = $_POST['code'];
$code_req = $_SESSION['pressure_id'];
if($code_req == "short press") {
  if($code_client < 0.2) {
    echo 'success';
  } else {
    echo "failure";
  }
} elseif ($code_req == "long press") {
  if($code_client > 0.7) {
    echo 'success';
  } else {
    echo "failure";
  }
} 
?>
