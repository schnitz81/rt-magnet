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
    along with rt-magnet.  If not, see <http://www.gnu.org/licenses/>.
-->
<html>
<head>
<script type="text/javascript">

function toggleText() {
   var textElement = document.getElementById("toggleText");
   var buttonElement = document.getElementById("toggleButton");
   if(textElement.style.display == "block") {
      textElement.style.display = "none";
      buttonElement.value = "Show";
   }
   else {
      textElement.style.display = "block";
      buttonElement.value = "Hide";
   }
}

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

// Get our target directories from the configuration file.
$directories = array_map
   ('dirname', array_map  // Extract the directory path for each line.
      ('trim', file       // Remove whitespace for each line.
         ($filepath)));   // Load config lines into an array.


function getCategoryName($strPath){ // Extract category names from every watchdir path.
   return basename($strPath); 
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
          foreach ($directories as $directory){
            $categoryName = getCategoryName($directory);
            echo "<option value=\"$directory\">$categoryName</option>";
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
<label for="showdirs">Show watch directories:</label>
<input id="toggleButton" type="button" value="Show" onclick="javascript:toggleText();" />
<div id="toggleText" style="display: none;">
  <?php
  foreach($directories as $directory)
    echo "  <h3>$directory</h3>\n";
  ?>
</div>
</body>
</html>