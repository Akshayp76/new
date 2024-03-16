<?php
require '../config.php';
?>
<link rel="stylesheet" href=<?php echo $base_url . "css/word_chain.css" ?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css" ?>>
<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <p>If
      <div class='ca-img-container'>
        <img class='ca-img' src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=0&width=200&height=48"; ?> id="captcha_image" />
      </div>
      is present in given statement, then press
      <div class='ca-img-container'>
        <img src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=1&width=130&height=38"; ?> id="yes" />
      </div>
      else, press
      <div class='ca-img-container'>
        <img src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=2&width=130&height=38"; ?> id="no" />
      </div>
      . The words are:
    </p>
    <div class='ca-img-container'>
      <img src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=3&width=300&height=400"; ?> id="stmt" />
    </div>
    <label>Write your Answer</label>
    <input class='ca-input' type="text" name="captcha_code" id="captcha_code" class="form-control" />
    <button class='ca-button' id="switch_lang" onclick="changeLanguage(event)">Switch language</button>
    <button class='ca-button' id='voice_inp' onclick="record(event)">Record Answer</button>
    <input class='ca-button' type="button" name="audio" id="audio" value="Audio" onclick="getAudio()" autofocus />
    <input class='ca-button' type="submit" name="register" id="submit" value="Check" />
    <!-- TODO: Modularize -->
    <audio id="valid">
      <source src=<?php echo $base_url . "assets/sounds/valid.mp3"; ?> type="audio/mp3">
    </audio>

    <audio id="enter">
      <source src=<?php echo $base_url . "assets/sounds/enter.mpeg"; ?> type="audio/mp3">
    </audio>

    <audio id="invalid">
      <source src=<?php echo $base_url . "assets/sounds/invalid.mp3"; ?> type="audio/mp3">
    </audio>
    <div id="ca-player">
    </div>
  </form>
</div>



<script>
  var base_url = "<?php echo $base_url; ?>";

  function record(e) {
    e.preventDefault();
    console.log('recording...');
    var recognitaion = new webkitSpeechRecognition();
    recognitaion.lang = "en-GB";
    recognitaion.onresult = function(event) {
      console.log(event);
      document.getElementById('captcha_code').value = document.getElementById('captcha_code').value + event.results[0][0].transcript;
    }
    recognitaion.start();
  }

  function getAudio() {
    var txt = jQuery('#txt').val();
    jQuery.ajax({
      /*url:'../audio_operations/word_chain_audio.php',*/
      url: base_url + "backend/audio_operations/word_chain_audio.php",
      type: 'post',
      success: function(result) {
        jQuery('#ca-player').html(result);
      }
    });
  }

  function changeLanguage(e) {
    e.preventDefault();
    $.ajax({
      //url:"../backend/captcha_pages/questionnaire.php",
      url: "../backend/index.php",
      method: "POST",
      data: {
        "captcha_type": "word_chain",
        "lang": "hi"
      },
      success: function(data) {
        jQuery('#captcha').html(data);
      }
    });
  }

  $(document).ready(function() {
    var v = document.getElementById("valid");
    var i = document.getElementById("invalid");
    var e = document.getElementById("enter");

    $('#captcha_form').on('submit', function(event) {
      event.preventDefault();
      var code = $('#captcha_code').val()
      console.log(code)
      if (code == '') {
        alert('Enter Captcha Code');
        //console.log("Here with empty code")
        //e.play();
        //$('#register').attr('disabled', 'disabled');
        return false;
      } else {
        // alert('Form has been validate with Captcha Code');
        $.ajax({
          url: base_url + "backend/validation/word_chain_validation.php",
          method: "POST",
          data: {
            code: code
          },
          success: function(data) {
            console.log(data)
            if (data == 'success') {
              v.play();
              alert("Successful Validation");
              $('.ca-panel-body').html("<h3 class='ca-validated'> Captcha Validated </h3>");
              //$('#register').attr('disabled', false);
            } else {
              i.play();
              alert("Unsuccessful validation");
              console.log('Invalid Code');
              $('#captcha_form')[0].reset();
            }
          }
        });
      }
    });
  });
</script>

<div id=arrow></div>
<script>
  function disp(str) {
    //alert(str);
    document.getElementById('arrow').innerHTML = str;
  }
  ////http://jsfiddle.net/JamesD/8q7Mu/
  document.onkeydown = function() {
    switch (window.event.keyCode) {
      case 87: //left arrow
        $("#captcha_code").focus();
        break;
      case 69: //left arrow
        $("#submit").focus();
        break;
      case 76: //up arrow
        $("#switch_lang").focus();
        break;

      case 82: //right key
        $('#voice_inp').focus();
        break;

      case 65:  //down key
        $('#audio').focus();
        break;

    }
  };
</script>