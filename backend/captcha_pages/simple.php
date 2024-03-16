<?php
require '../config.php';
?>
<!--
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
-->
<link rel="stylesheet" href=<?php echo $base_url . "css/simple.css"?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css"?>>
<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <div class="ca-form-group">
      <label class='ca-label'>Please enter the following letters in the box provided</label>
      <div class="ca-input-group">
        <div class="ca-img-container">
          <img class='ca-img' src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=0&width=200&height=38"; ?> id="captcha_image" />
        </div>
        <input type="text" name="captcha_code" id="captcha_code" class="ca-input ca-form-control" />
        <button class='ca-button' id='voice_inp' onclick="record(event)">Record Answer</button>
        <input type="button" name="audio" id="audio" class="ca-button" value="Audio" onclick="getAudio()" autofocus/>
        <input class='ca-button' id="submit" type="submit" value="Check"/>

      </div>
    </div>
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
var v = document.getElementById("valid"); 
var i = document.getElementById("invalid"); 
var e = document.getElementById("enter"); 

document.body.onkeyup = function(e){
    // Executed when spacebar pressed
    if(e.keyCode == 32){
      console.log('spacebar was pressed');
      getAudio();
    }
}
$('#captcha_form').on('submit', function(event){
  event.preventDefault();
  var code = $('#captcha_code').val()
  if(code == '') {
   alert('Enter Captcha Code');
   //console.log("Here with empty code")
   //e.play();
   //$('#register').attr('disabled', 'disabled');
   return false;
  } else {
  // alert('Form has been validate with Captcha Code');
    $.ajax({
      url: base_url + "backend/validation/simple.php",
      method:"POST",
      data:{code:code},
      success:function(data)
      {
        if(data == 'success') {
          v.play();
          alert("Successful Validation");
          console.log('valid code');
          $('.ca-panel-body').html("<h3 class='ca-validated'> Captcha Validated </h3>");
          //$('#register').attr('disabled', false);
        } else {
          i.play();
          alert("Unsuccessful validation");
          //$('#register').attr('disabled', 'disabled');
          //$('#captcha_image').attr('src', 'image.php');
          $('#captcha_form')[0].reset();
          console.log('Invalid Code');
        }
        /* TODO: Fix errors with the succeding line. */
      }
    });
  }
});

function getAudio() {
  var txt=jQuery('#txt').val();
  jQuery.ajax({
  /*url:'../audio_operations/word_chain_audio.php',*/
    url: base_url + "backend/audio_operations/word_chain_audio.php", 
    type:'post',
    success:function(result){
      jQuery('#ca-player').html(result);
    }
  });
}

$(document).ready(function(){
  /*
  $('#captcha_code').on('blur', function(){
    var code = $('#captcha_code').val();
    if(code == '') {
      alert('Enter Captcha Code');
      $('#register').attr('disabled', 'disabled');
    } else {
      $.ajax({
        url:"/opt/lampp/htdocs/captcha/check_code.php",
        method:"POST",
        data:{code:code},
        success:function(data) {
          if(data == 'success') {
            $('#register').attr('disabled', false);
          } else {
            $('#register').attr('disabled', 'disabled');
            alert('Invalid Code');
          }
        }
      });
    }
  });
  */
});
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


<div id=arrow></div>
<script>
  function disp(str) {
    //alert(str);
    document.getElementById('arrow').innerHTML = str;
  }
  ////http://jsfiddle.net/JamesD/8q7Mu/
  document.onkeydown = function() {
    switch (window.event.keyCode) {
      case 87: //
        $("#captcha_code").focus();
        break;
      case 69: 
        $("#submit").focus();
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
