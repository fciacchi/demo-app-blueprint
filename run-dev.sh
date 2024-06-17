#!/bin/sh

composer install
npm install
npm run db:migrate
npm run dev
