#!/bin/sh

php leaf db:reset
php leaf db:migrate
php leaf db:seed
