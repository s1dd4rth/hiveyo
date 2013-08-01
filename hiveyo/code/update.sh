#!/bin/bash
function age() {
   local filename=$1
   local changed=`stat -f %B "$filename"`
   local now=`date +%s`
   local str=`date -j -f %s "$changed"`
   local elapsed

   let elapsed=now-changed
   echo $str
}

file="./Archive.zip"
echo The age of $file is $(age "$file") seconds.