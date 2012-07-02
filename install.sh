#!/bin/bash

if [ "$(id -u)" != "0" ]; then
   echo "This install script needs to be run as root."; 
   exit 1
fi

echo
echo "Checking for rtorrent config file..."; sleep 1
echo
sleep 1 
if [ -s .rtorrent.rc ]; then
  echo ".rtorrent.rc found. Installation continues..." ; sleep 1
else
  echo "No valid .rtorrent.rc found in this directory! Quitting..."
  exit
fi

echo
echo "Checking for watch definitions in .rtorrent.rc..." ; sleep 1
echo
count=`cat ./.rtorrent.rc|grep load_start|wc -l`
if [ $count -lt 1 ]; then
	echo "No load_start found in .rtorrent.rc! Check your watch_directory definitions. Quitting..."
	exit;
else
	echo "Watch directories found! Installation continues..." ; sleep 1
fi


echo
echo "Checking for old config file..."; sleep 1
echo 
if [ -a /etc/rt-magnet.conf ]; then
  echo "Old config file exists! Do you want to overwrite and generate a new? (y/n)"
  read CONFIRM
  case $CONFIRM in
    y|Y|yes|YES|Yes) echo ;;
    *)
      echo " Quitting..."
      exit ;;
esac
else
   echo "No old config file found. Creating new." ; sleep 1
fi

echo
echo "Creating conf-file..."; sleep 1
echo
echo "# Automatically created by RT-magnet installer." > /etc/rt-magnet.conf
cat .rtorrent.rc | grep load_start | grep -v '#' >> /etc/rt-magnet.conf
echo "/etc/rt-magnet.conf created." ; sleep 1
echo

# Check if tilde is used
echo
echo "Checking for tilde usage in watchdir paths..."
sleep 1 ; echo
if grep -q 'load_start=~' /etc/rt-magnet.conf ; then
   echo "Tilde is being used! Replacing with extended paths..." ; sleep 1
else
   echo "No tilde usage found, all OK. Exiting..."
   exit;
fi

# Get home directory for current path hierarchy 
echo
echo "Checking for sane home dir in current path hierarchy..." ; sleep 1
echo
currentPath=$(cd "$( dirname "$0" )" && pwd)
if [[ "$currentPath" == "/root"* ]] ; then
   homedir="/root"
   echo "Home dir is /root."
elif [[ "$currentPath" == "/home"* ]] ; then
   #homedir=$(echo $currentPath | cut -f-3 -d'/') 
   homedir=`echo $currentPath | cut -f-3 -d'/'`
   echo "Home dir is $homedir."
else
   echo "Error: No sane homedir found. Make sure you are running the install script under /root or /home/* structure."
   exit;
fi

# Replace tilde with home path
echo
echo "Changing tilde to extended homedir paths.." ; sleep 1
SEARCH="load_start=~"
sed -i "s#${SEARCH}#load_start=${homedir}#g" /etc/rt-magnet.conf
echo
echo "All done. Exiting..."


