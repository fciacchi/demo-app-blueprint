![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blue)
![NODE 18.20](https://img.shields.io/badge/NODE-18.20-blue)
![npm 10.5](https://img.shields.io/badge/npm-10.5-blue)
[![Leaf PHP](https://img.shields.io/badge/Leaf-PHP-green)](https://leafphp.dev/)
[![License: MIT](https://img.shields.io/badge/License-MIT-orange)](https://opensource.org/licenses/MIT)

# README

## App Info

For this see the [Documentation](./DOCUMENTATION.md)

## Installation

```shell
# INSTALL COMPOSER
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
$ php -r "unlink('composer-setup.php');"
$ composer update
# INSTALL NPM
$ curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
$ nvm install 18
$ npm update
# SET-UP DATABASE
$ sudo apt install sqlite3 php8.2-sqlite3
$ composer global require leafs/cli
$ touch database/database.sqlite
$ php leaf db:migrate
$ php leaf db:seed
# SET-UP DEFAULT ENV
$ cp .env.example .env
```

## DEV Environment

Requirements:
* PHP Version: 8.2.18
* Node Version: 18.20.2
* NPM Version: 10.5.0

```shell
$ composer install
$ php leaf db:reset
$ npm i
$ npm run dev
```

Open: http://localhost:5500

### Database Local Debug

```shell
npx drizzle-kit studio
```

Open: https://local.drizzle.studio
