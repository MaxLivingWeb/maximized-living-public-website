#!/bin/bash
set -e

# set the folder in which to run the installs
cd /var/www/html/

if [ -f .env ]; then
    rm .env
fi

python CreateEnvFile.py

if [ -f CreateEnvFile.py ]; then
    rm CreateEnvFile.py
fi

if [ -f env.txt ]; then
    rm env.txt
fi

COMPOSER_HOME="/var/www/html" php composer.phar install

# Run Artisan Commands if needed
if [ -f artisan ]; then
    echo "APP_KEY=" >> .env
    php artisan key:generate
    php artisan migrate
fi

rm -f ./.htaccess

source ./public/EnvironmentSetting.sh

rm -f ./public/EnvironmentSetting.sh

chown -R apache:apache /var/www/html

