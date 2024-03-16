<?php
    require '../config.php';
    session_start();
    function str_replace_first($search, $replace, $subject) {
          $pos = strpos($subject, $search);
          if ($pos !== false) {
              return substr_replace($subject, $replace, $pos, strlen($search));
          }
          return $subject;
    }

    $dir = $base_location . "assets/audio/";
    $file = "tts";
    $file = $dir . $file . ".wav";
    $lang = $_SESSION['lang'];
    $q_string = $_SESSION['q_string'];
    $q_secret = $_SESSION['q_secret_audio'];

    $txt = $q_string;
    for($i = 0; $i < count($q_secret); $i++) {
      $txt = str_replace_first("|", $q_secret[$i], $txt); 
    }
    error_log($txt);
    
    /* Encode the input. */
    $txt=htmlspecialchars($txt);
    $txt=rawurlencode($txt);
    
    /* create a directory(if not exists) to store the audio files */
    if (!is_dir($dir)) {
        mkdir($dir, 0, true);
    } else {
        if (substr(sprintf('%o', fileperms($dir)), -4) != "0777")
            chmod($dir, 0777);
    }

    /* Make the curl request to get audio file */
    $curl = curl_init();
    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q='.$txt.'&tl='.$lang.'-IN',
      CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ]);
    $html = curl_exec($curl);
    curl_close($curl);

    /* save the audio file */
    file_put_contents($file, $html);

    $noise = $base_location . 'assets/sounds/guntrimmed.mp3';
    $audio = $base_location . 'assets/audio/tts.wav';

    
    $post_params['noise'] = $noise;
    $post_params['sound'] = $audio;
    

    // Get cURL resource
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => 'http://localhost:5000/audio/',
      CURLOPT_USERAGENT => 'Codular Sample cURL Request',
      CURLOPT_POST => 1,
      CURLOPT_POSTFIELDS => $post_params 
    ]);
    #curl_setopt($curl, CURLOPT_HTTPHEADER, array ('Content-Type: application/json'));
    $html = curl_exec($curl);
    // Close request to clear up some resources
    curl_close($curl);


    /* TODO: Fix some words being cut. */
    /* execute python script to get combined audio in base 64 and delete created files*/
    //$result_last_line = exec("python3 Audio.py $audio $noise ");
    #$result_last_line = exec("python3 audio1.py $noise $audio");

    /* Alternate way */
    /*$o = shell_exec('ffmpeg -y -i guntrimmed.wav -i wav.wav -filter_complex "[0:0]volume=0.05[a];[1:0]volume=2.2[b];[a][b]amix=inputs=2:duration=longest" -c:a libmp3lame again100.mp3 2>&1');*/

    /* send the file to client */
    $player1="<audio autoplay><source src='data:audio/mpeg;base64,".$html."'></audio>";
	echo $player1;
?>
