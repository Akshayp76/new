var comb = [];

function generate_random_keys() {
  var arr = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
             'Ctrl', 'Alt', 'Shift']
  for (var i = 0; i < 3; i++) {
      var rand = arr[(Math.floor(Math.random() * 10)) % arr.length];
      comb.push(rand);
    }
    return comb;
}

function request_events(event) {
  var comb = generate_random_keys();
  console.log(comb);
  document.addEventListener("keydown", handle_events, false);
}

function handle_events(event) {
  try {
    var code = -1;
    for(var i = 0; i < comb.length; i++) {
      if(comb[i] === 'Ctrl' && !event.ctrlKey) {
        return false;
      }
      else if(comb[i] === 'Alt' && !event.altKey) {
        return false;
      }
      else if(comb[i] === 'Shift' && !event.shiftKey) {
        return false;
      }

      code = comb.charCodeAt(i);

      if (event.keyCode != code) {
        return false;
      }
      e.preventDefault();  
    }
    return true;
  }
  catch(err) {

  }
  finally {
    comb = [];
  }
}

console.log(request_events());
