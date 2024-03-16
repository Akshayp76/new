<?php
  require '../config.php';
  session_start();

  $txt = $_SESSION['question'];
  $lang = $_SESSION['lang'];
	$txt=htmlspecialchars($txt);
	$txt=rawurlencode($txt);

  /*$html=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN', false, $context);*/

  // Get cURL resource
  $curl = curl_init();
  // Set some options - we are passing in a useragent too here
  curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl='. $lang. '-IN',
    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
  ]);
  // Send the request & save response to $resp
  $html = curl_exec($curl);
  // Close request to clear up some resources
  curl_close($curl);

  $file = 'que_audio';
  $file = "audio/" . $file . ".wav";
    if (!is_dir("audio/"))
        mkdir("audio/");
    else
        if (substr(sprintf('%o', fileperms('audio/')), -4) != "0777")
            chmod("audio/", 0777);
    if (!file_exists($file))
        {
            $html=file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl=en-IN');
            file_put_contents($file, $html);
        }

  $o = shell_exec('ffmpeg -y -i guntrimmed.wav -i audio/que_audio.wav -filter_complex "[0:0]volume=0.05[a];[1:0]volume=2.2[b];[a][b]amix=inputs=2:duration=shortest" -c:a libmp3lame output.mp3 2>&1');



  $background_noise_player="<audio volume='0.5' autoplay><source src='" . $base_url . "backend/audio_operations/output.mp3" . "'></audio>";
  echo $background_noise_player;

  echo "done"

	/*$question_player="<audio volume='1.9' id='aud' autoplay><source src='data:audio/mpeg;base64,".base64_encode($html)."'></audio>";
	echo $question_player;

  $background_noise_player="<audio volume='0.5' autoplay><source src='" . $base_url . "assets/sounds/gunsound.mp3" . "'></audio>";
	echo $background_noise_player;*/
    
?>
