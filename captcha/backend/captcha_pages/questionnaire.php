<html>  
    <head>  
        <title>Captcha</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container" style="width: 600px">
   <br />
   
   <h3 align="center">Captcha</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Register Form</div>
    <div class="panel-body">
     <form method="post" id="captch_form">
      <img src="../image_operations/questionnaire_image.php" id="captcha_image" /></br></br>
      <div class="form-group">
       <div class="form-group">
                          <label>Code</label>
                          <div class="input-group">
                           <input type="text" name="captcha_code" id="captcha_code" class="form-control" autocomplete="off"/>
                           <span class="input-group-addon" style="padding:0">
            </span>
                          </div>
                         </div>
      </div>
         
       
        <audio id="valid">
          <source src="../../assets/sounds/valid.mp3" type="audio/mp3">
        </audio> 
       
	<!--
       <audio id="enter">
          <source src="enter.mp3" type="audio/mp3">
        </audio> 
	-->

       <audio id="invalid">
          <source src="../../assets/sounds/invalid.mp3" type="audio/mp3">
        </audio>       

        <div id="player"></div>
         
        <div class="form-group">
            <input type="button" name="audio" id="audio" class="btn btn-info" value="Audio" onclick="getAudio()" autofocus/>
        </div>
        <!--<form method="post">
            <input type="button" name="submit" value="Audio" onclick="getAudio()"/>
        </form>-->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
            function getAudio(){
                var txt=jQuery('#txt').val()
                jQuery.ajax({
                    url:'../audio_operations/questionnaire_audio.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
            }
        </script>

     
      <div class="form-group">
       <input type="submit" name="register" id="register" class="btn btn-info" value="Register" onclick = "checkValidity()"/>
      </div>
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
            function checkValidity(){
                var txt=jQuery('#txt').val()
                jQuery.ajax({
                    url:'../audio_operations/questionnaire_audio.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
            }
        </script>
     </form>
    </div>
   </div>
  </div>
    
    </body>  
</html>




<script>
 $(document).ready(function(){
     var v = document.getElementById("valid"); 
     var i = document.getElementById("invalid"); 
     var e = document.getElementById("enter"); 
  
  $('#captch_form').on('submit', function(event){
   event.preventDefault();
   if($('#captcha_code').val() == '')
   {
    //alert('Enter Captcha Code');
    //e.play();
    $('#register').attr('disabled', 'disabled');
    return false;
   }
   else
   {
    //alert('Form has been validate with Captcha Code');
    v.play();
    $('#captch_form')[0].reset();
    $('#captcha_image').attr('src', '../image_operations/questionnaire_image.php');
   }
  });
  $('#captcha_code').on('blur', function(){
   var code = $('#captcha_code').val();
   
   if(code == '')
   {
    //alert('Enter Captcha Code');
    //e.play();
    $('#register').attr('disabled', 'disabled');
   }
   else
   {
    $.ajax({
     url:"../validation/questionnare_validation.php",
     method:"POST",
     data:{code:code},
     success:function(data)
     {
      if(data == 'success')
      {
       $('#register').attr('disabled', false);
      }
      else
      {
       $('#register').attr('disabled', 'disabled');
       //alert('Invalid Code');
       i.play();
      }
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

        case 39:
         $('#register').focus();
         break;

        case 40:
         $('#audio').focus();
         break; 
        
    }
};



//-->
</script>

