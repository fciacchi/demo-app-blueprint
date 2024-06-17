#!/bin/sh

# INSTALL COMPOSER
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
composer update
# INSTALL NPM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
nvm install 18
npm update
# SET-UP DATABASE
sudo apt install sqlite3 php8.2-sqlite3
composer global require leafs/cli
touch database/database.sqlite
php leaf db:migrate
php leaf db:seed
# SET-UP DEFAULT ENV
cp .env.example .env