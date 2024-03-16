<?php
function translate($text, $lang) {
  if($lang == 'en') {
    return $text;
  }
	$text=htmlspecialchars($text);
	$text=rawurlencode($text);

  $curl = curl_init();
  // Set some options - we are passing in a useragent too here
  curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://api.mymemory.translated.net/get?q='.$text.'&langpair=en|'.$lang,
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
  ]);
  // Send the request & save response to $resp
  $html = curl_exec($curl);
  error_log($html);
  // Close request to clear up some resources
  curl_close($curl);
  $obj = json_decode($html, true);
  return $obj['responseData']['translatedText'];
}

function translateQuestion($lang, $word, $yes, $no, $stmt) {
  if($lang == 'en') {
    $ans = "If ".$word." is present in given statement then press ".$yes.". else press ".$no." The words are".$stmt;
    return $ans;
  }
  if($lang == 'mr') {
    $ans = "जर" . $word . "उपस्थित असेल तर" . $yes . "डाबा  नाहीतर" . $no . "डाबा";
    return $ans;
  }
  if($lang == 'hi') {
    $ans = "यदि" . " " .$word . " " . "मौजूद है, तो" . " " . $yes . " " . "दबाएँ, अन्यथा" . " " . $no . " " . "दबाएँ";
    $ans = $ans . "शब्द हैं" . $stmt;
    return $ans;
  }
}
function getWordChainQuestion($lang) {
  if($lang == 'en') {
    $ans = "If | is present in given statement then press | else press | The words are |";
    return $ans;
  }
  if($lang == 'mr') {
    $ans = "जर | उपस्थित असेल तर | डाबा  नाहीतर | डाबा. शब्द आहेत | ";
    return $ans;
  }
  if($lang == 'hi') {
    $ans = "यदि | मौजूद है, तो | दबाएँ, अन्यथा | दबाएँ. शब्द हैं | ";
    return $ans;
  }
}
?>
