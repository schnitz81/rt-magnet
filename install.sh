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
    echo "No old config file found. Creating new."; sleep 1
fi


#echo "DEBUG part"
echo
echo "Creating conf-file..."; sleep 1
echo
#touch /etc/rt-magnet.conf
echo "# Automatically created by RT-magnet installer." > /etc/rt-magnet.conf
cat .rtorrent.rc | grep watch_directory | grep -v '#' >> /etc/rt-magnet.conf
echo "/etc/rt-magnet.conf created. Exiting..."
echo
exit;

