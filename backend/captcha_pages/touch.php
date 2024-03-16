<?php
require '../config.php';
?>
<link rel="stylesheet" href=<?php echo $base_url . "css/touch.css"?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css"?>>
<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <label class='ca-label'>Perform the following action</label>
    <div class='ca-img-container'>
      <img class='ca-img' id="captcha_image" />
    </div>
    <!--<div class="touch-sensor" style="height:200px;width:400px;background:lightblue"></div>-->
    <input type="button" name="audio" id="audio" class="ca-button" value="Audio" onclick="getAudio(event)" autofocus/>
    <button class='ca-button' id="switch_lang" onclick="changeLanguage(event)">Switch language</button>
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
  </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.js"></script>
<script>
var base_url = "<?php echo $base_url; ?>";
var elem_width = document.getElementsByClassName("ca-panel-body")[0].getBoundingClientRect()
elem_width = elem_width.width;
img_width = elem_width - 20;
$('.ca-img').attr("src", base_url + "backend/image_operations/questionnaire_image.php?id=0&height=40&width=" + img_width);

function getAudio(e){
  console.log("fetching audio");
  e.stopPropagation();
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
function changeLanguage(e) {
  e.preventDefault();
  $.ajax({
   //url:"../backend/captcha_pages/questionnaire.php",
   url:"../backend/index.php",
   method:"POST",
   data:{"captcha_type" : "touch",
         "lang" : "hi"
        },
   success:function(data) {
     jQuery('#captcha').html(data);
   }
  });
}
var v = document.getElementById("valid"); 
var i = document.getElementById("invalid"); 
var e = document.getElementById("enter"); 

function sendRequest(value) {
  console.log(value);
  $.ajax({
    url: base_url + "backend/validation/touch_validation.php",
    method:"POST",
    data:{code:value},
    success:function(data)
    {
      console.log(data)
      if(data == 'success') {
        v.play();
        alert("Successful Validation");
        $('.ca-panel-body').html("<h3 class='ca-validated'> Captcha Validated </h3>");
        //$('#register').attr('disabled', false);
      } else {
        i.play();
        alert("Unsuccessful validation");
        //$('#register').attr('disabled', 'disabled');
        //$('#captcha_image').attr('src', 'image.php');
        console.log('Invalid Code');
      }
    }
  });
};
function isAButton(ele) {
  var buttons = document.getElementsByClassName('ca-button');
  var buttons_array = [...buttons];
  if (buttons_array.includes(ele)) {
    return true;
  } else {
    return false;
  }
}
$(document).ready(function(){
  //var touch_sensor = document.querySelector('.touch-sensor');
  var touch_sensor = document.querySelector('body');
  var hammer = new Hammer(touch_sensor);
  var manager = new Hammer.Manager(touch_sensor);
  var hammer = new Hammer(touch_sensor);
// Create a recognizer
  var Tap = new Hammer.Tap({
    taps: 1
  });
  var DoubleTap = new Hammer.Tap({
    event: 'doubletap',
    taps: 2 
  });
  var Swipe = new Hammer.Swipe();

   // Add the recognizer to the manager
  //manager.add(Tap);
  DoubleTap.recognizeWith(Swipe);
  manager.add(Tap);
  manager.add(Swipe);

  // Subscribe to the desired event
  var myVar;
  var n = 0;
  manager.on('tap', function(e) {
    if(isAButton(e.target))  {
      return;
    }
    n = n + 1;
    clearTimeout(myVar);
    myVar = setTimeout(function() {
      console.log('inside');
      console.log(n);
      sendRequest(n);
      n = 0;
    }, 1000);
  });

  manager.on('doubletap', function(e) {
    console.log('doubletap');
  });

  var deltaX = 0;
  var deltaY = 0;

  manager.on('swipe', function(e) {
    var direction = e.offsetDirection;
    console.log('swiping ' + direction);
    sendRequest("none");
  });
  /*

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
*/
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