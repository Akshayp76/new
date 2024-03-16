// Example of change method with a failure closure
// This structure can be used in any methods of Pressure
// The failure block will return with an "error" and message showing why the device doesn't support 3D Touch and Force Touch

$.pressureConfig({
  polyfill: false
});
var s = 0;
var block = {
  start: function(event){
    console.log('start', event);
    s = 0;
  },

  change: function(force, event){
    // event.preventDefault();
    //this.style.width = Pressure.map(force, 0, 1, 200, 300) + 'px';
    this.innerHTML = force;
   
    s = force;
    console.log('change', force);
    //console.log('mahi' + s);
  },

  startDeepPress: function(event){
    console.log('start deep press', event);
    this.style.backgroundColor = '#FFFFFF';
  },

  /*endDeepPress: function(){
    console.log('end deep press');
    this.style.backgroundColor = '#0080FF';
  },*/
	
   /*end: function(){
   	alert(force);
   }*/
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
/*$("el2").mouseover(function(){

    $("el2").css("cursor","pointer");
});
window.onload=function(){
  document.getElementById("el2").click();
};*/
//<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
/*$('#guide').click(function(){
	jQuery.ajax({
                    url:'guide.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
      $("body").load("inde.html");
});*/

$('body').mousedown(function(){
	//alert("hello");
	jQuery.ajax({
                    url:'cc.mpeg',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
      //$("body").load("inde.html");
});

$('body').mouseup(function(){
	var x = s;
	if(x > 0.8){
		jQuery.ajax({
                    url:'valid.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
	}
	else{
	jQuery.ajax({
                    url:'invalid.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
	}
});

/*$('#btn').click(function(){
	var x = s;
	//alert("echo");
	if(x < 0.3){
	//alert("echo");
		//var txt=jQuery('#txt').val
		//alert("see " + x);
		jQuery.ajax({
                    url:'valid.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
                $("body").load("inde.html");
                
	}
	else{
		//alert("see " + x);
		jQuery.ajax({
                    url:'invalid.php',
                    type:'post',
                    success:function(result){
                        jQuery('#player').html(result);
                    }
                });
                $("body").load("inde.html");

	}
});*/


Pressure.set($('#el2'), block, {only: 'mouse', polyfill: true, polyfillSpeedUp: 2000});

$('img').pressure({
  change: function(force, event){
    console.log(force);
  }
});
