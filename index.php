<html>
<head>
<script language="javascript"> 
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

$arrLinesMasked = array_map(trim, file_get_contents($filepath));

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
<a id="displayText" href="javascript:toggle();">show watch directories...</a>
<div id="toggleText" style="display: none"><h3>

<?php
foreach($arrLinesMasked as $arrItem)
  echo $arrItem,"<br>";
?>

</h3>
</div>
</html>
