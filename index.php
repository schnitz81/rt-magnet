<html>
<head>
<script type="text/javascript">
// Get the actual CSS value
function get_style(element, style_property) {
	if(element.currentStyle) { //Internet Explorer
		return self.currentStyle[style_property];
	} else if(window.getComputedStyle) { //Firefox
		return window.getComputedStyle(element, null).getPropertyValue(style_property);
	} else { //Get inlined value
		return element.style[style_property];
        }
}
// Manage the toggle button, and elements visibility
// Returns an event handler.
function bindToggleElements(button, element) {
	function hidden(elm) {
		return get_style(elm, "display") == "none";
	}
	function hide(elm) {
		elm.style.display = "none";
	}
	function show(elm) {
		elm.style.display = "block";
	}
	return function(event) {
		if( hidden(element) ) {
			show(element);
			button.innerHTML = "Hide text";
		} else {
			hide(element);
			button.innerHTML = "Show text";
		}
	};
}
// Add a toggle button
function addShowHideButtons(event) {
	var button = document.createElement("button");
	var element= document.getElementById("toggleText");
	button.innerHTML = "Toggle Visibility";
	// Add button before element
	element.parentNode.insertBefore(button, element);
	// Add events to handle a click, and then fire it to update the button and element
	// states.
	if(button.attachEvent) { //Internet Explorer
		button.attachEvent("onclick", bindToggleElements(button, element));
		button.fireEvent("onclick", document.createEventObject());
	} else if(window.addEventListener) { //w3c
		button.addEventListener("click", bindToggleElements(button, element));
		e = document.createEvent("HTMLEvents");
		e.initEvent("click", true, true);
		button.dispatchEvent(e);
	} else { //inline
		// Make sure we don't overwrite existing events by saving them to old_event
		button.onclick = function(old_event, new_event) {
			return function(event) {
				old_event.apply(this, [event]);
				new_event.apply(this, [event]);
			}
		}(button.onclick || function(event) {}, bindToggleElements(button, element))
		button.onclick();
	}
}
// Add the button when the site has finished loading
function(context) {
	if(context.attachEvent) { // windows
		context.attachEvent("onload", addShowHideButtons);
	} else if(context.addEventListener) { // W3C
		context.addEventListener("load", addShowHideButtons);
	} else { // inline
		old_onload = context.onload || function(event) {};
		context.onload = function(old_onload) {
			return function(event) {
				addShowHideButtons.apply(this, [event]);
				old_onload.apply(this, [event]);
			};
		}(old_onload);
	}
}(window);

</script>
</head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>


<?php
echo "<title>RT-magnet</title>";
echo "<form action='magnet.php' method='post'>";
echo "<br>";

$filepath = '/etc/rt-magnet.conf';

if(!file_exists($filepath)){
   echo "Error: $filepath does not exist. Run install script first.";
   exit;
}

$lines = file($filepath);

$nrOfCategories = count(preg_grep("/load_start/",$lines));    
if($nrOfCategories<1){
   echo "Error: No instances of load_start found in config file!";
   exit;
}

// Read file into array
$pattern = '/load_start=(.+\/)([0-9A-Za-z#*$%=@!{}~&()<>?.:;_|^]+[ 0-9A-Za-z#*$%=@!{}~&()<>?.:;_|^]+\,)/i';
$arrLinesMasked = array();
foreach( $lines as $line ){
  if( preg_match( $pattern, $line, $matches ) )
    $arrLinesMasked[] = trim($matches[1]);
}


function getCategoryName($strPath){            // Extract category names from every watchdir path
   $intSlashPos = strrpos($strPath, "/", -2);
   return substr($strPath,$intSlashPos+1,-1);
}



// Generate page:

echo "<pre>";
echo "                                                                                                          <br>";
echo "          _/_/_/    _/_/_/_/_/                                                                    _/      <br>";
echo "         _/    _/      _/              _/_/_/  _/_/      _/_/_/    _/_/_/  _/_/_/      _/_/    _/_/_/_/   <br>";
echo "        _/_/_/        _/  _/_/_/_/_/  _/    _/    _/  _/    _/  _/    _/  _/    _/  _/_/_/_/    _/        <br>";
echo "       _/    _/      _/              _/    _/    _/  _/    _/  _/    _/  _/    _/  _/          _/         <br>";
echo "      _/    _/      _/              _/    _/    _/    _/_/_/    _/_/_/  _/    _/    _/_/_/      _/_/      <br>";
echo "                                                                   _/                                     <br>";
echo "                                                              _/_/                                        <br>";
echo "</pre><br />";

echo "Magnet link: <input type='text' name='magnetlink' size='120' /><br /><br />";
echo "Category:&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<select name='formCategory'>";
echo "<option value=''></option>"; 		// Empty alternative by default (force to choose)
foreach ($arrLinesMasked as $strPath ){ 	// Generate drop-down menu
   $categoryName = getCategoryName($strPath);
   echo "<option value='$strPath'>$categoryName</option>";
} //for
echo "</select>";
echo "<br />";
?>
<br><br>
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<input type='submit' value='Send' />
</form><br /><br />;

<!------ Show and hide option to display array of watch directories. --> 
<div id="toggleText"><h3>

<?php
foreach($arrLinesMasked as $arrItem)
  echo $arrItem,"<br>";
?>

</h3>
</div>
</html>
