<?php
require '../config.php';
?>
<!--<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@0.11.2"></script>-->
<script src=<?php echo $base_url . "js/paint.js"?>></script>
<script src=<?php echo $base_url . "js/predicter.js"?>></script>
<link href=<?php echo $base_url . "css/main.css"?> rel="stylesheet">
<link rel="stylesheet" href=<?php echo $base_url . "css/questionnaire.css"?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css"?>>

<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <label class='ca-label'>Draw a </label>
    <div class='ca-img-container'>
      <img src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=0&height=40&width=200"; ?> id="captcha_image" />
    </div>
    <div>
      <canvas id="canvas"></canvas> 
    </div>
    <!--<button class='ca-button' id='switch_lang' onclick="changeLanguage(event)">Switch language</button>-->
    <input type="button" name="audio" id="audio" class="ca-button" value="Audio" onclick="getAudio()" autofocus/>
    <input type="submit" name="register" id="submit" class="ca-button" value="Check"/>
    <div>
      <audio id="valid">
        <source src=<?php echo $base_url . "assets/sounds/valid.mp3"; ?> type="audio/mp3">
      </audio> 
       
      <audio id="enter">
        <source src=<?php echo $base_url . "assets/sounds/enter.mpeg"; ?> type="audio/mp3">
      </audio> 

      <audio id="invalid">
        <source src=<?php echo $base_url . "assets/sounds/invalid.mp3"; ?> type="audio/mp3">
      </audio>       
      <div id="player">
      </div>
    </div>
  </form>
</div>
<script>
var base_url = "<?php echo $base_url; ?>";
var v = document.getElementById("valid"); 
var i = document.getElementById("invalid"); 
var e = document.getElementById("enter"); 
function getAudio(){
  var txt=jQuery('#txt').val();
  jQuery.ajax({
      /*url:'../audio_operations/word_chain_audio.php',*/
      url: base_url + "backend/audio_operations/word_chain_audio.php", 
      type:'post',
      success:function(result){
          jQuery('#player').html(result);
      }
  });
}
console.log('here');
$('#captcha_form').on('submit', function(event){
  event.preventDefault();
  event.stopPropagation();
  console.log(letter);
  $.ajax({
    url: base_url + "backend/validation/letter_recognition.php",
    method:"POST",
    data:{letter:letter["letter"]},
    success:function(data)
    {
      console.log(data)
      if(data == 'success') {
        v.play();
        alert("Successful Validation");
        $('#captcha').html("<h3> Captcha Validated </h3>");
        //$('#register').attr('disabled', false);
      } else {
        i.play();
        alert("Unsuccessful validation");
        paintBackground();
        //$('#register').attr('disabled', 'disabled');
        //$('#captcha_image').attr('src', 'image.php');
        console.log('Invalid Code');
      }
      $('#captcha_form')[0].reset();
    }
  });
})
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
        $("#register").focus();
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
