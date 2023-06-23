#!/bin/bash
date

echo "Veuillez saisir la date du jour dans le format suivant : Tue Feb 14 14:00:00 2023"
read user_date

sudo date -s "$user_date"

echo "Nous somme le : $user_date"

./piface/libpifacecad/pifacecad open
./piface/libpifacecad/pifacecad write "$user_date"


sudo service apache2 start
sudo sudo service mariadb start
sudo /etc/init.d/domoticz.sh start

