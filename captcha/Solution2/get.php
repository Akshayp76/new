<?php
    session_start();
	$txt=" ";
    $yes = $_SESSION['yes'];
    $no = $_SESSION['no'];
    $cap = $_SESSION['cap'];
    $stmt = $_SESSION['stmt'];
    $txt = ".If. ".$cap.". is. present. in given statement then press. ".$yes.". else. press. ".$no.". The. words. are.".$stmt;
	$txt=htmlspecialchars($txt);
	$txt=rawurlencode($txt);
	$html=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
	$player="<audio id='aud' autoplay><source src='data:audio/mpeg;base64,".base64_encode($html)."'></audio>";
    
	echo $player;
    $player1="<audio autoplay><source src='guntrimmed.mp3'></audio>";
	echo $player1;
    
?>
