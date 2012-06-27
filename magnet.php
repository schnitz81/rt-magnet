<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?php


$magnetlink = $_POST['magnetlink'];
//$varCategory = $_POST['formCategory'];
$watchDirectory = $_POST['formCategory'];


if($watchDirectory==''){
  print "No category selected!";
  exit;
}

// Check if watch directory exists
elseif(!is_dir($watchDirectory)){
   print "Watch directory not accessible.";
   exit;
}

// Check watch directory writability

if(!is_writable(substr($watchDirectory,0,-1))){
   print "Watch directory is not writable. Please change folder permissions.";
   exit;
}


function checkValidLink($magnetlink)
{
   $needle = 'magnet:';
   if(strstr($magnetlink,$needle) === FALSE)
      return FALSE;
   else
      return TRUE;
}

if(!checkValidLink($magnetlink)){
   print "Magnetlink has to start with 'magnet:'";   /* print $magnetlink; */
   exit;
}

if(strlen($magnetlink)<12){
   print "Invalid magnetlink! Too short.";
   exit;
}




$i = 1;
while ($i <= 50) {
   if (!file_exists ( $watchDirectory."new".$i.".torrent"  ) )
	break;
   $i++;
}

if ($i > 50){
   print "Maximum nr of files exceeded!";
   exit;
}

$filePath = $watchDirectory."new".$i.".torrent";

function makeTorrentFromMagnet($magnetlink)
{
   return "d10:magnet-uri".strlen($magnetlink).":$magnetlink"."e";
}

file_put_contents($filePath,makeTorrentFromMagnet($magnetlink));
print "Magnetlink added!";

?>
</body>
</html>
