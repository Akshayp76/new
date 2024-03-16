<?php
    session_start();
	$txt=" ";
    $yes = $_SESSION['yes'];
    $no = $_SESSION['no'];
    $cap = $_SESSION['cap'];
    $stmt = $_SESSION['stmt'];
    $txt = $cap;
	$txt=htmlspecialchars($txt);
	$txt=rawurlencode($txt);
	$html=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
	$player="<audio volume = '100.0' id='aud' autoplay><source src='data:audio/mpeg;base64,".base64_encode($html)."'></audio>";
    
	echo $player;
    $player1="<audio volume = '0.0' autoplay><source src='../../assets/sounds/gunsound.mp3'></audio>";
	echo $player1;
    
?>
