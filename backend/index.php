<?php

require './translate.php';
// Report all errors
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set("log_errors", 1);
session_start();
$lang = $_POST['lang'];
if(isset($_POST['lang'])) {
  $lang = $_POST['lang'];
  $_SESSION['lang'] = $lang;
}

$shapes_arr = array('circle', 'triangle', 'banana', 'hand', 'pants', 'square', 't-shirt');
$pressure_arr= array("short press", "long press");
$questionnaire_arr = array("Identify the animal.\n1) Elephant.\n2) Hibiscus.\n3) Earth.\n4) Sun."  => 'elephant', "Identify the animal.\n1) Dog.\n2) China.\n3) Banana.\n4) Apple. " => 'dog', "Identify the animal.\n1) Mango.\n2) Apple.\n3) Cat.\n4) Peach. " => 'cat', "Identify the animal.\n1) Mars.\n2) Dog.\n3) Earth.\n4) Sun. " => 'dog', "Identify the animal.\n1) Cat.\n2) Banana.\n3) Earth.\n4) Sun. " => 'cat', "Identify the flower.\n1) Dog.\n2) Lotus.\n3) Banana.\n4) Apple. " => 'lotus', "Identify the flower.\n1) Mango.\n2) Apple.\n3) Rose.\n4) Peach. " => 'rose',"Identify the planet.\n1) Dog.\n2) China.\n3) Banana.\n4) Earth. " => 'earth' , "Identify the day.\n1) Sunday.\n2) China.\n3) Banana.\n4) Apple. " => 'sunday', "Identify the month.\n1) Elephant.\n2) December.\n3) Earth.\n4) Sun. " => 'december');
$word_chain_arr = array("dog", "cat", "cow", "sheep", "lion", "tiger", "monkey", "donkey", "hibiscus", "tulip", "rose", "lotus", "sunflower", "apple", "lemon", "orange", "fig", "grapes", "banana", "kiwi", "peach", "potato", "spinach", "mushroom", "cabbage", "beetroot", "corn", "carrot", "plum", "apricot", "broccoli", "cauliflower", "olive", "sun", "moon", "venus", "mercury", "earth", "mars", "jupiter", "saturn", "uranus", "neptune", "january", "february", "march", "april", "may", "june", "july", "september", "october", "november", "december", "sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "is", "are", "was", "were", "will", "animal", "flower", "fruit", "flower", "planet", "month");
$touch_array = array("press", "swipe");

function getUniqueRandomNumbersWithinRange($min, $max, $quantity) {
  $numbers = range($min, $max);
  shuffle($numbers);
  return array_slice($numbers, 0, $quantity);
}

function getElement($index) {
  return $GLOBALS['word_chain_arr'][$index]; 
}

if(isset($_SESSION['validated']) && $_SESSION["validated"] == 'true') {
  echo "Validated";
}

if(isset($_POST['captcha_type'])) {
  $captcha_type = $_POST['captcha_type'];
  echo "redirectign to " . $captcha_type;
} else {
  $captcha_type = "simple";
}

// Simple Captcha
if($captcha_type == 'simple') {
  //TODO: problems with audio of 'e'

  //Get random letters
  $random_alpha = md5(rand());

  // Trim to 6 letters
  $captcha_code = substr($random_alpha, 0, 6);

  // Add , between letters for accurate audio conversion
  $captcha_code_audio = implode(",", str_split($captcha_code));

  // Save these in session variables
  $_SESSION['q_string'] = "Type the following letters |";
  $_SESSION['q_secret_img'] = [$captcha_code];
  $_SESSION['q_secret_audio'] = [$captcha_code_audio];
  $_SESSION['answer'] = $captcha_code;

  // Send corresponding captcha page to client
  header('Location: '.'./captcha_pages/simple.php');
  die();
}

// Questionnaire Captcha
if($captcha_type == 'questionnaire') {

  // Choose a random question from array of questions
  $question = array_rand($questionnaire_arr);

  // Break into comma seperated individual words to improve translation
  $text_to_be_translated = implode(",", explode("\n", $question)); 

  // Join back translated words 
  $translated_text = implode("\n", explode(",", translate($text_to_be_translated, $lang))); 

  $answer = $questionnaire_arr[$question];

  // Save these values in session variables
  $_SESSION['q_string'] = "|";
  $_SESSION['q_secret_img'] = [$translated_text];
  $_SESSION['q_secret_audio'] = [$translated_text];
  $_SESSION['answer'] = $answer; 

  // Send corresponding captcha page to client
  header('Location: '.'./captcha_pages/questionnaire.php');
  die();
}

// Word-Chain Captcha
if($captcha_type == 'word_chain') {

  // Get multiple random elements from word_chain array
  $random_index = getUniqueRandomNumbersWithinRange(0, count($word_chain_arr), 8);
  $random_array = array_map("getElement", $random_index);

  // translate the chosen elements
  $str_to_be_translated= implode(", ", $random_array);
  $translated_str = translate($str_to_be_translated, $lang);
  $random_array = explode(", ", $translated_str);

  // create the options string
  $stmt = "";
  for($i = 0; $i < 7; $i++){
      $index = $random_index[$i]; 
      //$stmt = $stmt."\n".$word_chain_arr[$index];
      $stmt = $stmt."\n". $random_array[$i];
  }

  //$_SESSION['stmt'] = $stmt;

  //Randomly decide if object is present or not.
  $elem_in_stmt = rand(0,1);

  //Get the word to be checked for membership.
  $word="";
  if($elem_in_stmt) {
    $elem_index = rand(0, 6);
    //$word = $word_chain_arr[$random_index[$elem_index]];
    $word = $random_array[$elem_index];
  } else {
    $word = $random_array[7];
  }

  //Get the buttons to be pressed for yes & no cases.
  $seed = str_split('abcdefghijklmnopqrstuvwxyz'); // TODO: Add other possible buttons.
  shuffle($seed); 
  $yes = $seed[0];
  $no = $seed[1];

  // Save these values in session variables
  $_SESSION['yes'] = $yes;
  $_SESSION['no'] = $no;
  #$_SESSION['question'] = translateQuestion($lang, $word, $yes, $no, $stmt);
  $_SESSION['q_secret_img'] = [$word, $yes, $no, $stmt];
  $_SESSION['q_secret_audio'] = [$word, $yes, $no, $stmt];
  #$_SESSION['q_string'] = "If | is present in given statement then press | else press | . The words are | "; 
  $_SESSION['q_string'] = getWordChainQuestion($lang); 

  // Send corresponding captcha page to client
  header('Location: '.'./captcha_pages/word_chain.php');
  die();
}

// Touch Captcha
if($captcha_type == 'touch') {
  // choose between press and swipe. If press ,chose a random no for num of touches between 1 and 5.
  $question = array_rand($touch_array);
  if($question== 0) {
    $no_of_presses = rand(1, 6);
    //$no_of_presses = 5;
    $question_stmt = $touch_array[$question] . " " . $no_of_presses . " times";
  } else {
    $question_stmt = $touch_array[$question]; 
    $no_of_presses = "none";
  }

  // translate the text by converting to csv first
  $text_to_be_translated = implode(",", explode("\n", $question_stmt)); 
  $translated_text = implode("\n", explode(",", translate($text_to_be_translated, $lang))); 

  // set values
  $_SESSION['taps'] = $no_of_presses;
  $_SESSION['q_secret_audio'] = [$translated_text];
  $_SESSION['q_secret_img'] = [$translated_text];
  $_SESSION['q_string'] = "Perform the following | "; 

  // send page to client
  header('Location: '.'./captcha_pages/touch.php');
  die();
}

// Scribble detection captcha
if($captcha_type == 'object_detection') {
  // choose a random shape that is to be drawn
  $question = array_rand($shapes_arr);

  // set session values
  $_SESSION['shape_id'] = $question;
  $shape = translate($shapes_arr[$question], $lang);
  $_SESSION['q_secret_img'] = [$shape];
  $_SESSION['q_secret_audio'] = [$shape];
  $_SESSION['q_string'] = "Draw a | "; 

  // send page to client
  header('Location: '.'./captcha_pages/object_detection.php');
  die();
}

// pressure detection captcha
if($captcha_type == 'pressure') {

  //choose a random type of question
  $question = array_rand($pressure_arr);
  $pressure_type = translate($pressure_arr[$question], $lang);

  // set session values 
  $_SESSION['pressure_id'] = $pressure_type; 
  $_SESSION['q_secret_audio'] = [$pressure_type];
  $_SESSION['q_secret_img'] = [$pressure_type];
  $_SESSION['q_string'] = " | the given area"; 

  // send page to client
  header('Location: '.'./captcha_pages/simple_pressure.php');
  die();
}

// letter recognition captcha
if($captcha_type == 'letter_recognition') {

  //Choose a random letter
  $seed = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ'); // TODO: Add other possible buttons.
  shuffle($seed); 
  $letter = $seed[0];

  $_SESSION['answer'] = $letter;
  $_SESSION['q_secret_audio'] = [$letter];
  $_SESSION['q_secret_img'] = [$letter];
  $_SESSION['q_string'] = "Draw letter | in the given area"; 

  // send page to client
  header('Location: '.'./captcha_pages/letter_recognition.php');
  die();
}

if($captcha_type == 'digit_recognition') {

  //Choose a random letter
  $seed = str_split('0123456789'); // TODO: Add other possible buttons.
  shuffle($seed); 
  $num = $seed[0];

  $_SESSION['answer'] = $num;
  $_SESSION['q_secret_audio'] = [$num];
  $_SESSION['q_secret_img'] = [$num];
  $_SESSION['q_string'] = "Draw number | "; 

  // send page to client
  header('Location: '.'./captcha_pages/digit_recognition.php');
  die();
}
if($captcha_type == 'digit_recognition') {

  //Choose a random letter
  $seed = str_split('0123456789'); // TODO: Add other possible buttons.
  shuffle($seed); 
  $letter = $seed[0];

  $_SESSION['answer'] = $letter;
  $_SESSION['q_secret_audio'] = [$letter];
  $_SESSION['q_secret_img'] = [$letter];
  $_SESSION['q_string'] = "Draw digit | in the given area"; 

  // send page to client
  header('Location: '.'./captcha_pages/digit_recognition.php');
  die();
}
?>
