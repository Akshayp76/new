<?php

session_start();

$letter_client = $_POST['letter'];
$letter_req = $_SESSION['answer'];
$rslt = "";
error_log($letter_client);
if($letter_client == $letter_req) {
  echo 'success';
} else {
  echo "failure";
}
?>
