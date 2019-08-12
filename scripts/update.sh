#!/bin/bash
ssh u68857@u68857.netangels.ru '
cd u68857.netangels.ru/www
git reset --hard
git pull origin master
./yii migrate --interactive = 0
'