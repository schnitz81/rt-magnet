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

if(!is_writable(substr($watchDirectory,0))){
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
   if (!file_exists ( $watchDirectory."/"."new".$i.".torrent"  ) )
	break;
   $i++;
}

if ($i > 50){
   print "Maximum nr of files exceeded!";
   exit;
}

$filePath = $watchDirectory."/"."new".$i.".torrent";

function makeTorrentFromMagnet($magnetlink)
{
   return "d10:magnet-uri".strlen($magnetlink).":$magnetlink"."e";
}

file_put_contents($filePath,makeTorrentFromMagnet($magnetlink));
print "Magnetlink added!";

?>
</body>
</html>
