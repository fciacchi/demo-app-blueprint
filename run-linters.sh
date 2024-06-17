# !/bin/sh

./vendor/bin/phpcbf app/
./vendor/bin/phpcs app/
./vendor/bin/phpstan analyse -c phpstan.neon
./vendor/bin/rector process app/
npm run lint:fix