#!/bin/bash

set -e

# set the folder in which to run the installs
cd /var/www/html/

# ensure composer is installed
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '106d3d32cc30011325228b9272424c1941ad75207cb5244bee161e5f9906b0edf07ab2a733e8a1c945173eb9b1966197') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

echo $DEPLOYMENT_GROUP_NAME > env.txt

pip install boto3
