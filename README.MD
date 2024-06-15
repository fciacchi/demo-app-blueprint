# README

This README would normally document whatever steps are necessary to get the
application up and running.

Things you may want to cover:

## App Info

## Installation

### Set-up

```shell
# INSTALL COMPOSER
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
$ php -r "unlink('composer-setup.php');"
$ composer update
# INSTALL NPM
$ sudo apt-get install build-essential
$ curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
$ nvm install 18
$ npm update
# SET UP DATABASE
$ sudo apt install sqlite3 php8.2-sqlite3
$ composer global require leafs/cli
$ touch database/database.sqlite
$ php leaf db:migrate
```

### DEV Environment

Requirements:
* PHP Version: 8.2.18
* Node Version: 18.20.2
* NPM Version: 10.5.0

```shell
$ composer install
$ php leaf db:migrate
$ npm i
$ npm run dev
```

Database Local Debug

```shell
npx drizzle-kit studio
```

Open: https://local.drizzle.studio

## System dependencies

## Configuration

## Deployment instructions

