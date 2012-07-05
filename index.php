<!--This file is part of rt-torrent.

    rt-torrent is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    rt-magnet is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
<head>
<script type="text/javascript"> 
function toggle() {
	var ele = document.getElementById("toggleText");
	var text = document.getElementById("displayText");
	if(ele.style.display == "block") {
    		ele.style.display = "none";
		text.innerHTML = "show watch directories...";
  	}
	else {
		ele.style.display = "block";
		text.innerHTML = "hide";
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
}(window);

</script>

<title>rt-magnet</title>
</head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?php
$filepath = '/etc/rt-magnet.conf';

if(!file_exists($filepath)){
   echo "Error: $filepath does not exist. Run install script first.";
   exit;
}

$arrLinesMasked = array_map(trim, file_get_contents($filepath));

function getCategoryName($strPath){            // Extract category names from every watchdir path
   $intSlashPos = strrpos($strPath, "/", -2);
   return substr($strPath,$intSlashPos+1,-1);
}

// Generate page:
?>
<pre>
                                                                                                          
                                                                                                      
                      _/                                                                            _/      
         _/  _/_/  _/_/_/_/              _/_/_/  _/_/      _/_/_/    _/_/_/  _/_/_/      _/_/    _/_/_/_/   
        _/_/        _/      _/_/_/_/_/  _/    _/    _/  _/    _/  _/    _/  _/    _/  _/_/_/_/    _/        
       _/          _/                  _/    _/    _/  _/    _/  _/    _/  _/    _/  _/          _/         
      _/            _/_/              _/    _/    _/    _/_/_/    _/_/_/  _/    _/    _/_/_/      _/_/      
                                                                     _/                                     
                                                                _/_/                                        
</pre>
<br />

<form action="magnet.php" method="post" border="0">
  <table>
    <tr>
      <td>
        <label for="magnetlink">Magnet link:</label>
      </td>
    </tr>
    <tr>
      <td>
        <textarea name="magnetlink" id="magnetlink" onfocus="if(this.value==this.defaultValue)this.value='';" cols=50 rows=6 />
	   Paste magnetlink here:
	</textarea>
      </td>
    </tr>
    <tr>
      <td>
        <label for="formCategory">Category:</label>
        <select name="formCategory" id="formCategory">
          <?php
          // Empty alternative by default (force to choose)
          echo "<option value=''></option>";
          // Generate drop-down menu
          foreach ($arrLinesMasked as $strPath ){
            $categoryName = getCategoryName($strPath);
            echo "<option value='$strPath'>$categoryName</option>";
          } //for
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <input type="submit" value="Send" />
      </td>
    </tr>
  </table>
</form>
<br />
<br />
<!------ Show and hide option to display array of watch directories. --> 
<a id="displayText" href="javascript:toggle();">show watch directories...</a>
<div id="toggleText" style="display: none">
=======
<div id="toggleText"><h3>

<?php
foreach($arrLinesMasked as $arrItem)
  echo "<h3>$arrItem</h3>";
?>
</div>
</body>
</html>
