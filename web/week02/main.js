/**
 * This is a shortcut to jQuery ready function. It's called right after DOM is loaded and ready.
 */
$(function() {
  // this event handles click to change first div color
  $("#change-color-jquery").click(function() {
    var color = $("#color-1").val();

    // some sanity check on color
    if (!/^#*[A-Fa-f0-9]{6}$/.test(color)) {
      alert(
        "This is an invalid color. Use color in RGB Hex format. Example: #FFff00"
      );
      return;
    }

    // this change color using jQuery
    $("#div-1").css(
      "background-color",
      (color.charAt(0) !== "#" ? "#" : "") + color
    );

    $("#div-1").css(
        "color",
        getTextColor(color)
    );
  });

  // this event handles the div 3 visibility using jQuery
  $("#change-visibility").click(function() {
    $("#div-3").fadeToggle("slow");
  });
});

/**
 * This method does a fancy stuff, popping an alert message.
 */
function doFancyStuff() {
  alert("Clicked!");
}

/**
 * This function changes the color of the div 1 container.
 * @param {Object} container
 * @param {String} color
 */
function changeColorVanilla(container, color) {
  // sanity check on color format
  if (!/^#*[A-Fa-f0-9]{6}$/.test(color)) {
    alert(
      "This is an invalid color. Use color in RGB Hex format. Example: #FFff00"
    );
    return;
  }

  // effectively change color using DOM directly
  container.style.backgroundColor =
    (color.charAt(0) !== "#" ? "#" : "") + color;

  container.style.color = getTextColor(color);
}

/**
 * This function calculates the text color for a div when color is changed.
 * 
 * @param {String} hexcolor 
 */
function getTextColor (hexcolor){

	// If a leading # is provided, remove it
	if (hexcolor.slice(0, 1) === '#') {
		hexcolor = hexcolor.slice(1);
	}

	// Convert to RGB value
	var r = parseInt(hexcolor.substr(0,2),16);
	var g = parseInt(hexcolor.substr(2,2),16);
	var b = parseInt(hexcolor.substr(4,2),16);

	// Get YIQ ratio
	var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;

	// Check contrast
    return (yiq >= 128) ? '#000000' : '#ffffff';
}
