


function validate(evt) {
    var theEvent = evt || window.event;
  
    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
    // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[A-Z, a-z]|\./;
    if( !regex.test(key) ) {
  
        alertify.error('Please enter only letter!');
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    }
  }
  
  