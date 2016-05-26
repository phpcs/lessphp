#!/bin/bash

path=$(ls $1)

for i in $path
do
    mv $1$i $(sed "s/JPG/jpg/" <<< $1$i)
done

