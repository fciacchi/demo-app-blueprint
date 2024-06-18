#!/bin/sh

sudo composer global require leafs/cli
cp .env.example .env
touch database/database.sqlite
php leaf db:migrate
php leaf db:seed
