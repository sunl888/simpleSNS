#!/bin/sh

set -e

if [ ! -d vendor ]
then
    composer config -g repo.packagist composer https://packagist.phpcomposer.com
    composer install --prefer-dist --optimize-autoloader
fi

#if [ ! -d node_modules ]
#then
#   npm install --registry=https://registry.npm.taobao.org
#fi
chown -R www-data:www-data /var/www/bootstrap
chown -R www-data:www-data /var/www/storage
chown -R www-data:www-data /var/www/public
chmod -R 775 /var/www/bootstrap
chmod -R 775 /var/www/storage
chmod -R 775 /var/www/public

php /var/www/artisan key:generate

# wait for mysql

until php -r 'try {
    $dbh = new PDO("$argv[1]:host=$argv[2];dbname=$argv[3]", $argv[4], $argv[5]); //初始化一个PDO对象 \
    echo "mysql connected ok\n";
    $dbh = null;
} catch (PDOException $e) {
    fwrite(STDERR, "mysql is unavailable!: " . $e->getMessage() . "\n");
    exit(1);
}' -- ${DB_CONNECTION} ${DB_HOST} ${DB_DATABASE} ${DB_USERNAME} ${DB_PASSWORD} ; do
  sleep 1
done


php /var/www/artisan migrate --seed

php-fpm
