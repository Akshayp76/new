<?php
require '../config.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<div class="panel-body">
  <form method="post" id="captcha_form">
    <img src=<?php echo $base_url . "backend/image_operations/word_chain_image.php"; ?> id="que" />
    <br>
    <br>

    <div class="form-group">
      <label>Write your Answer</label>
      <div class="input-group">
        <input type="text" name="captcha_code" id="captcha_code" class="form-control" />
        <span class="input-group-addon" style="padding:0">
        </span>
      </div>
    </div>
    <div class="form-group">
      <label>Use Microphone to speak Answer</label>
      <div class="input-group">
        <input type="text" name="" id="speechtotext" onclick=record()>
        <span class="input-group-addon" style="padding:0">
        </span>
      </div>

    </div>
    <div>
    <label>Change the Language</label>

    <div id="google_translate_element"></div>

<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <br>
    </div>

    <div>
    <script>
		function record() {		
			var recognitaion = new webkitSpeechRecognition();
			recognitaion.lang = "en-GB";
			recognitaion.onresult = function(event){
				console.log(event);
				document.getElementById('speechtotext').value = event.results[0][0].transcript;
			}
			recognitaion.start();
			// body...
		}
	</script>
    </div>
    

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
    <div id="player">
    </div>
    <div class="form-group">
      <input type="button" name="audio" id="audio" class="btn btn-info" value="Audio" onclick="getAudio()" autofocus/>
    </div>


    <script>
      var base_url = "<?php echo $base_url; ?>";
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
    </script>
    <div class="form-group">
      <input type="submit" name="register" id="register" class="btn btn-info" value="Register" onclick="checkValidity()"/>
    </div>
  </form>
</div>



<script>
$(document).ready(function(){
  var v = document.getElementById("valid"); 
  var i = document.getElementById("invalid"); 
  var e = document.getElementById("enter"); 

  $('#captcha_form').on('submit', function(event){
    event.preventDefault();
    var code = $('#captcha_code').val()
    console.log(code)
    if(code == '') {
     alert('Enter Captcha Code');
     //console.log("Here with empty code")
     //e.play();
     //$('#register').attr('disabled', 'disabled');
     return false;
    } else {
    // alert('Form has been validate with Captcha Code');
      $.ajax({
        url: base_url + "backend/validation/word_chain_validation.php",
        method:"POST",
        data:{code:code},
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
            //$('#register').attr('disabled', 'disabled');
            //$('#captcha_image').attr('src', 'image.php');
            console.log('Invalid Code');
          }
          $('#captcha_form')[0].reset();
        }
      });
    }
  });
});
</script>

<div id=arrow></div>
<script>
<!--
function disp(str){
//alert(str);
document.getElementById('arrow').innerHTML=str;
}

document.onkeydown = function() {
    switch (window.event.keyCode) {
        case 38:
         $("input:text").focus(); 
         break;
        
    }
};


//-->
</script>
