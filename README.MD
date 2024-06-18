![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blue)
![Node 18.20](https://img.shields.io/badge/Node-18.20-blue)
![npm 10.5](https://img.shields.io/badge/npm-10.5-blue)
[![Leaf PHP](https://img.shields.io/badge/Leaf-PHP-green)](https://leafphp.dev/)
[![License: MIT](https://img.shields.io/badge/License-MIT-orange)](https://opensource.org/licenses/MIT)

# README

## App Info

For this see the [Documentation](./DOCUMENTATION.md)

## Set-up

To run the application locally we assume you have a Linux Debian/Ubuntu
machine wiht the following:

<details>
  <summary>PHP 8.2+ (and SQLite support)</summary>

```shell
# Install PHP and Composer
$ sudo apt install php8.2 sqlite3 php8.2-sqlite3
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
$ php -r "unlink('composer-setup.php');"
$ composer update
```
</details>

<details>
  <summary>Node 18.20+ and npm 10.5</summary>

```shell
# Install Node and npm
$ curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
$ nvm install 18
$ npm update
```
</details><br />

For semplicity you can also run:

```shell
$ chmod a+x run-*.sh
$ ./run-setup.sh
```

## Installation

If you intend to use SQLite (and your PHP supports it), you can prepare the application by running the 
following command:

```shell
$ chmod a+x run-*.sh
$ ./run-install.sh
```

<details>
  <summary>If you want to run the installer manually</summary>

```shell
$ composer global require leafs/cli
$ cp .env.example .env
$ touch database/database.sqlite
$ php leaf db:migrate
$ php leaf db:seed
```
</details><br />

If you are not planning on using SQLite, but a hosted MySQL or 
PosgreSQL DB, you should edit your `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

## DEV Environment

```shell
$ ./run-dev.sh
```

Open: http://localhost:5500

<details>
  <summary>If you want to run DEV manually</summary>

```shell
$ composer install
$ npm install
$ npm run db:migrate
$ npm run dev
```
</details>

## Database

### Reset (+seeding)

```shell
$ ./run-db.sh
```

<details>
  <summary>If you want to reset DB manually</summary>

```shell
$ composer install
$ php leaf db:reset
$ php leaf db:migrate
$ php leaf db:seed
```
</details>

### Local access (SQLite)

```shell
$ npx drizzle-kit studio
```

Open: https://local.drizzle.studio

## Linters

To run the linters, you can run the following command:


```shell
$ ./run-linters.sh
```

<details>
  <summary>If you want to run linters manually</summary>

```shell
$ ./vendor/bin/phpcbf app/
$ ./vendor/bin/phpcs app/
$ ./vendor/bin/phpstan analyse -c phpstan.neon
$ ./vendor/bin/rector process app/
```
</details>

## Tests

To run the tests, you can run the following command:

```shell
$ ./run-tests.sh
```

<details>
  <summary>If you want to run the tests manually</summary>

```shell
$ ./vendor/bin/phpunit
```
</details>

## Plugins

<a href="./assets/postman/chrome-app/postman_extension_5_5_6_0.crx"><img src="./assets/images/plugin-postman.png" width="40" alt="Postman"></a>
<a href="https://marketplace.visualstudio.com/items?itemName=ryanluker.vscode-coverage-gutters"><img src="https://ryanluker.gallerycdn.vsassets.io/extensions/ryanluker/vscode-coverage-gutters/2.11.1/1699832082510/Microsoft.VisualStudio.Services.Icons.Default" width="40" alt="Coverage Gutters"></a>
<a href="https://marketplace.visualstudio.com/items?itemName=bmewburn.vscode-intelephense-client"><img src="https://bmewburn.gallerycdn.vsassets.io/extensions/bmewburn/vscode-intelephense-client/1.10.4/1711417500317/Microsoft.VisualStudio.Services.Icons.Default" width="40" alt="PHP Intelephense"></a>
<a href="https://marketplace.visualstudio.com/items?itemName=qwtel.sqlite-viewer"><img src="https://qwtel.gallerycdn.vsassets.io/extensions/qwtel/sqlite-viewer/0.6.0/1717998730126/Microsoft.VisualStudio.Services.Icons.Default" width="40" alt="SQLite Viewer"></a>
<a href="https://marketplace.visualstudio.com/items?itemName=cweijan.vscode-mysql-client2"><img src="https://cweijan.gallerycdn.vsassets.io/extensions/cweijan/vscode-mysql-client2/7.4.9/1718354428567/Microsoft.VisualStudio.Services.Icons.Default" width="40" alt="MySQL"></a>
