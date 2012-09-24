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
  if [ -w $RT_MAGNET_CONFIG ]; then
    # First get all non-comments section, extract load_start value, replace ~ 
    # with the $HOME variable, and dump it in the config file.
    grep -ohP '^[^#]{1,}' $RT_CONFIG | grep -ohP '(?<=load_start=)[^,]{1,}' | sed -e "s#~#$HOME##" > $RT_MAGNET_CONFIG
  echo "Config file created."
  else
    echo "Can't write to configuration file! Exiting..."
    exit 1
  fi
else
  echo "$RT_CONFIG was not found in this directory!"
  echo "Exiting..."
  exit 1
fi

exit 0
