<?php
require '../config.php';
?>
<script type="text/javascript" src="../dependencies/pressure-master/dist/pressure.js"></script>
<script type="text/javascript" src="../dependencies/pressure-master/dist/jquery.pressure.js"></script>

<link rel="stylesheet" href=<?php echo $base_url . "css/questionnaire.css"?>>
<link rel="stylesheet" href=<?php echo $base_url . "css/common.css"?>>

<div class="ca-panel-body">
  <form method="post" id="captcha_form">
    <label class='ca-label'>Pressure Captcha</label>
    <div class='ca-img-container'>
      <img src=<?php echo $base_url . "backend/image_operations/questionnaire_image.php?id=0&width=400&height=40"; ?> id="captcha_image" />
    </div>
    <button id="audio" class="ca-button" onclick="getAudio(event)">Audio</button>
    <button class='ca-button' id='switch_lang' onclick="changeLanguage(event)">Switch language</button>

    <audio id="valid">
      <source src=<?php echo $base_url . "assets/sounds/valid.mp3"; ?> type="audio/mp3">
    </audio> 
     
    <audio id="enter">
      <source src=<?php echo $base_url . "assets/sounds/enter.mpeg"; ?> type="audio/mp3">
    </audio> 

    <audio id="invalid">
      <source src=<?php echo $base_url . "assets/sounds/invalid.mp3"; ?> type="audio/mp3">
    </audio>       
    <div id="player"></div>
  </form>
</div>



<script>
function changeLanguage(e) {
  e.preventDefault();
  $.ajax({
   //url:"../backend/captcha_pages/questionnaire.php",
   url:"../backend/index.php",
   method:"POST",
   data:{"captcha_type" : "pressure",
         "lang" : "hi"
        },
   success:function(data) {
     jQuery('#captcha').html(data);
   }
  });
}

var base_url = "<?php echo $base_url; ?>";
var v = document.getElementById("valid"); 
var i = document.getElementById("invalid"); 
var e = document.getElementById("enter"); 
$.pressureConfig({
  polyfill: false
});

function getAudio(e){
  e.preventDefault();
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

function isAButton(ele) {
  console.log(ele);
  var buttons = document.getElementsByClassName('ca-button');
  console.log(buttons);
  var buttons_array = [...buttons];
  if (buttons_array.includes(ele)) {
    console.log('here');
    return true;
  } else {
    console.log('hre');
    return false;
  }
}

var s = 0;
var block = {
  start: function(event){
    console.log(event);
    if(isAButton(event.target)) {
      return;
    }
    console.log('start', event);
    s = 0;
  },

  change: function(force, event){
    console.log(event);
    if(isAButton(event.target)) {
      return;
    }
    // event.preventDefault();
    //this.style.width = Pressure.map(force, 0, 1, 200, 300) + 'px';
    s = force;
    console.log('change', force);
    //console.log('mahi' + s);
  },

  startDeepPress: function(event){
    console.log(event);
    if(isAButton(event.target)) {
      return;
    }
    console.log('start deep press', event);
  },

  /*endDeepPress: function(){
    console.log('end deep press');
    this.style.backgroundColor = '#0080FF';
  },*/
	
   end: function(e){
    console.log(e);
    /*
    if(isAButton(e.target)) {
      return;
    }
    */
    if(s == 0) {
      console.log('returing');
      return;
    }
    $.ajax({
      url: base_url + "backend/validation/pressure_validation.php",
      method:"POST",
      data:{code:s},
      success:function(data)
      {
        console.log(data)
        if(data == 'success') {
          v.play();
          alert("Successful Validation");
          $('.ca-panel-body').html("<h3 class='ca-validated'> Captcha Validated</h3>");
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
   },
  /*end: function(){
    console.log('end');
    this.style.width = '200px';
    this.innerHTML = 0;
  },*/

  unsupported: function(){
    console.log(this);
    this.innerHTML = 'Your device / browser does not support this :(';
  }
}
Pressure.set($('body'), block, {only: 'mouse', polyfill: true, polyfillSpeedUp: 2000});
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
