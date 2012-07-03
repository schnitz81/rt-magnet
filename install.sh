#!/bin/bash
RT_MAGNET_CONFIG="/etc/rt-magnet.conf" # global file for 
RT_CONFIG=".rtorrent.rc" # Local settings for rtorrent
UNIQ=true # Force the config file to only contain unique paths
#VERBOSE=false # not in use


CONFIG_DIR=$(dirname $RT_CONFIG)
if [ "$CONFIG_DIR" == "." ]; then
  CONFIG_DIR=$(pwd)
fi

# Make sure we can write to the target path
if [ -w $CONFIG_DIR ]; then
  touch $RT_MAGNET_CONFIG
else
  echo "Can't write to configuration directory"
  echo "Exiting..."
  exit 1
fi

# Add all load_start values to the config file
if [ -s $RT_CONFIG ]; then
  # First get all non-comments section, extract load_start value, replace ~ 
  # with the $HOME variable, and dump it in the config file.
  grep -ohP '^[^#]{1,}' $RT_CONFIG | grep -ohP '(?<=load_start=)[^,]{1,}' | sed -e "s#~#$HOME##" >> $RT_MAGNET_CONFIG
else
  echo "$RT_CONFIG was not found in this directory!"
  echo "Exiting..."
  exit 1
fi

<<<<<<< HEAD

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
echo "Changing tilde to extended home dir paths..." ; sleep 1
SEARCH="load_start=~"
sed -i "s#${SEARCH}#load_start=${homedir}#g" /etc/rt-magnet.conf
echo
echo "All done. Exiting..."


=======
# Since we don't reset the file, we may get duplicates, which we can fix if we
# set the UNIQ flag at the top of the file.
if [ $UNIQ == true ]; then
  sort -u $RT_MAGNET_CONFIG -o $RT_MAGNET_CONFIG
fi

exit 0
>>>>>>> 1ded771fe0ffdbb12594b9ed1d29aef939787f88
