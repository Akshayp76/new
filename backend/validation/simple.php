<?php

//check_code.php

session_start();

$code_client = $_POST['code'];
$code_req = $_SESSION['answer'];
$rslt = "";
if($code_client == $code_req) {
  echo 'success';
} else {
  echo "failure";
}

?>
