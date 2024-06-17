# !/bin/sh

./vendor/bin/phpcs app/
./vendor/bin/phpcbf app/
./vendor/bin/phpstan analyse -c phpstan.neon
./vendor/bin/rector process app