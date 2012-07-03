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
	}
} 
</script>

<title>RT-magnet</title>
</head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?php
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
?>
<pre>
                                                                                                          
          _/_/_/    _/_/_/_/_/                                                                    _/      
         _/    _/      _/              _/_/_/  _/_/      _/_/_/    _/_/_/  _/_/_/      _/_/    _/_/_/_/   
        _/_/_/        _/  _/_/_/_/_/  _/    _/    _/  _/    _/  _/    _/  _/    _/  _/_/_/_/    _/        
       _/    _/      _/              _/    _/    _/  _/    _/  _/    _/  _/    _/  _/          _/         
      _/    _/      _/              _/    _/    _/    _/_/_/    _/_/_/  _/    _/    _/_/_/      _/_/      
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
      <td>
        <input type="text" name="magnetlink" id="magnetlink" size="120" />
      </td>
    </tr>
    <tr>
      <td>
        <label for="formCategory">Category:</label>
      </td>
      <td>
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
<?php
foreach($arrLinesMasked as $arrItem)
  echo "<h3>$arrItem</h3>";
?>
</div>
</body>
</html>
