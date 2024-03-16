<?php
    session_start();
	//$txt=" ";
    //alert("amhi");
    $txt = "";
	$txt=htmlspecialchars($txt);
	$txt=rawurlencode($txt);
	$html=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
	$player="<audio control id='aud' autoplay><source src='data:audio/mpeg;base64,".base64_encode($html)."'></audio>";
     
    
	echo $player;
    $player1="<audio autoplay><source src='enter.mpeg'></audio>";
	echo $player1;
    
?>
