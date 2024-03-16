$(document).ready(function() {
    var captcha_type = $("#captcha").attr("class");
    console.log(captcha_type);
    $.ajax({
     //url:"../backend/captcha_pages/questionnaire.php",
     url:"../backend/index.php",
     method:"POST",
     data:{"captcha_type" : captcha_type,
           "lang" : "en"       
     },
     success:function(data) {
       jQuery('#captcha').html(data);
     }
    });
});
