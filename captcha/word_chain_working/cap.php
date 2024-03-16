<html>  
    <head>  
        <title>How to implement Custom Captcha Code in PHP</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>  
    <body>  
        <div class="container" style="width: 600px">
   <br />
   
   <h3 align="center">How to implement Custom Captcha Code in PHP</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Register Form</div>
    <div class="panel-body">
     <form method="post" id="captch_form">
      <p>If <img src="newimage.php" id="captcha_image" /> is present in given statement, then press <br><img src="yes.php" id="yes" /> else, press <img src="no.php" id="no" />. The words are:</p><br> <img src="stmt.php" id="stmt" /><br><br>
      <div class="form-group">
       <div class="form-group">
                          <label>Code</label>
                          <div class="input-group">
                           <input type="text" name="captcha_code" id="captcha_code" class="form-control" />
                           <span class="input-group-addon" style="padding:0">
            </span>
                          </div>
                         </div>
      </div>
         
      <audio id="valid">
          <source src="valid.mp3" type="audio/mp3">
        </audio> 
       
       <audio id="enter">
          <source src="enter.mp3" type="audio/mp3">
        </audio> 

       <audio id="invalid">
          <source src="invalid.mp3" type="audio/mp3">
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
                    url:'get.php',
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

      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script>
            function checkValidity(){
                var txt=jQuery('#txt').val()
                jQuery.ajax({
                    url:'get.php',
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
	/*text2speech($string){
             $letters = explode($string);
             foreach($letters as $letter){ play_sound($letter); }
         }
         play_sound($letter){
             $letter."mp3".play();
             while($letter.isPlaying() == true){ wait for the sound to finish }
         }*/

 $(document).ready(function(){

    var v = document.getElementById("valid"); 
     var i = document.getElementById("invalid"); 
     var e = document.getElementById("enter"); 
  
  
  $('#captch_form').on('submit', function(event){
   event.preventDefault();
   var code = $('#captcha_code').val()
   console.log(code)
   if($('#captcha_code').val() == '')
   {
    //alert('Enter Captcha Code');
    console.log("Here with empty code")
    e.play();
    $('#register').attr('disabled', 'disabled');
    return false;
   }
   else
   {
   // alert('Form has been validate with Captcha Code');
   console.log("Not empty")
   console.log()
   $.ajax({
     url:"check_code.php",
     method:"POST",
     data:{code:code},
     success:function(data)
     {
         console.log(data)
      if(data == 'success')
      {
        console.log("Here I am submitted")
        v.play();
       $('#register').attr('disabled', false);
      }
      else
      {
          i.play();
       $('#register').attr('disabled', 'disabled');
       console.log('Invalid Code');
      }
     }
    });
    $('#captch_form')[0].reset();
    $('#captcha_image').attr('src', 'image.php');
   }
  });

  $('#captcha_code').on('blur', function(){
   var code = $('#captcha_code').val();
   
   if(code == '')
   {
    //alert('Enter Captcha Code2323');
     console.log("Here with empty code")
     e.play();
    $('#register').attr('disabled', 'disabled');
   }
   else
   {
    console.log("came here now will submit")
    $.ajax({
     url:"check_code.php",
     method:"POST",
     data:{code:code},
     success:function(data)
     {
      if(data == 'success')
      {
          v.play()
          console.log("Here I am submitted")
       $('#register').attr('disabled', false);
      }
      else
      {
        i.play()
       $('#register').attr('disabled', 'disabled');
       console.log('Invalid Code');
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
        
    }
};


//-->
</script>
