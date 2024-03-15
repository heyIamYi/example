#!/usr/bin/env bash

# create .env file
if [ ! -f .env ];then
    cp .env.example .env
    echo 'Create .env file success!';
    else
    echo '.env file already exists!';
fi

# install composer
if [ ! -f composer.phar ];then
    curl -sS https://getcomposer.org/installer | php
    echo 'Install composer success!';
    else
    echo 'skip step, composer already exists!';
fi

# craete env key
if grep -q "APP_KEY=base64:" .env; then
    echo "laravel key already exists"
else
    php artisan key:generate
    echo "laravel key create success"
fi

if [ ! -d public/storage ];then
    php artisan storage:link
    echo 'Create storage link success!';
    else
    echo 'skip step, storage link already exists!';
fi

# create seeders menus data
SEEDER_PATH="database/seeds/json"
SOURCE_PATH="${SEEDER_PATH}/menuExamplse.json"
DEST_FILE="${SEEDER_PATH}/menus.json"

if [ ! -f "${DEST_FILE}"]; then
    cp ${SOURCE_PATH} ${DEST_FILE}
else
    echo 'skip step, menus data already exists!';
fi

echo 'Environment build finish!';
