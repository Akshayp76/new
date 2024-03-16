<?php
require '../config.php';
?>
<!--
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
-->
<link rel="stylesheet" href=<?php echo $base_url . "css/questionnaire.css"?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css"?>>

<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <label class='ca-label'>Solve the question below and write your answer in the space provided below</label>
    <div class='ca-img-container'>
      <img class="ca-img"  id="captcha_image" />
    </div>
    <input class='ca-input' type="text" name="captcha_code" id="captcha_code" class="form-control" autocomplete="off"/>
    <button class='ca-button' id='switch_lang' onclick="changeLanguage(event)">Switch language</button>
    <button class='ca-button' id='voice_inp' onclick="record(event)">Record Answer</button>
    <input class='ca-button' type="button" name="audio" id="audio" value="Audio" onclick="getAudio()" autofocus/>
    <input class='ca-button' type="submit" name="register" id="submit"  value="Check" />

    <audio id="valid">
      <source src=<?php echo $base_url . "assets/sounds/valid.mp3"; ?> type="audio/mp3">
    </audio> 
    
    <audio id="enter">
      <source src=<?php echo $base_url . "assets/sounds/enter.mpeg"; ?> type="audio/mp3">
    </audio> 

    <audio id="invalid">
      <source src=<?php echo $base_url . "assets/sounds/invalid.mp3"; ?> type="audio/mp3">
    </audio>       
    <div id="ca-player"></div>
  </form>
</div>

<script>
var base_url = "<?php echo $base_url; ?>";
var elem_width = document.getElementsByClassName("ca-panel-body")[0].getBoundingClientRect()
elem_width = elem_width.width;
img_width = elem_width - 20;
$('.ca-img').attr("src", base_url + "backend/image_operations/questionnaire_image.php?id=0&height=400&width=" + img_width);
$(document).ready(function(){
  var v = document.getElementById("valid"); 
  var i = document.getElementById("invalid"); 
  var e = document.getElementById("enter"); 
  
  $('#captcha_form').on('submit', function(event){
    event.preventDefault();
    var code = $('#captcha_code').val();
    if(code == '') {
      alert('Enter Captcha Code');
      return false;
    } else {
      $.ajax({
        url: base_url + "backend/validation/questionnare_validation.php",
        method:"POST",
        data:{code:code},
        success:function(data) {
          if(data == 'success') {
            v.play();
            alert("Successful Validation");
            $('.ca-panel-body').html("<h3 class='ca-validated'> Captcha Validated </h3>");
          } else {
          i.play();
          alert("Unsuccessful Validation");
          console.log('Invalid Code');
          $('#captcha_form')[0].reset();
          //alert('Invalid Code');
          }
        }
      });
    }
  });
 });
</script>

<div id=arrow></div>
<script>
function disp(str){
//alert(str);
  document.getElementById('arrow').innerHTML=str;
  document.onkeydown = function() {
    switch (window.event.keyCode) {
        case 38:
         $("input:text").focus(); 
         break;

        case 39:
         $('#register').focus();
         break;

        case 40:
         $('#audio').focus();
         break; 
        
    }
  }
};
</script>
<script type="text/javascript">
function record(e) {		
  e.preventDefault();
  console.log('recording...');
  var recognitaion = new webkitSpeechRecognition();
  recognitaion.lang = "en-GB";
  recognitaion.onresult = function(event){
    console.log(event);
    document.getElementById('captcha_code').value = document.getElementById('captcha_code').value + event.results[0][0].transcript;
  }
  recognitaion.start();
}
function changeLanguage(e) {
  e.preventDefault();
  $.ajax({
   //url:"../backend/captcha_pages/questionnaire.php",
   url:"../backend/index.php",
   method:"POST",
   data:{"captcha_type" : "questionnaire",
         "lang" : "hi"
        },
   success:function(data) {
     jQuery('#captcha').html(data);
   }
  });
}
</script>
<script>
function getAudio() {
    var txt=jQuery('#txt').val()
    jQuery.ajax({
        //url:'../audio_operations/questionnaire_audio.php',
        //url:'http://localhost/captcha-alternative/backend/audio_operations/questionnaire_audio.php',
    url: base_url + "backend/audio_operations/word_chain_audio.php", 
        type:'post',
        success:function(result){
            jQuery('#ca-player').html(result);
        }
    });
}
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
