#!/bin/bash

path=`ls $1`

for i in $path
do
    str=$(basename $i .JPG)
    echo $str
    `mv $1$i  $1$str.jpg`
done
