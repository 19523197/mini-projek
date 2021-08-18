#!/bin/bash

if [ ! -f '/var/www/html/.env' ]; then
    cp /var/www/html/.env.prod /var/www/html/.env
    php /var/www/html/artisan key:generate
fi

sh /root/build-conf.sh

rm -f /var/www/html/storage/logs/lumen.log
touch /var/www/html/storage/logs/lumen.log
chown -R nobody.www-data /var/www/html/storage/logs/lumen.log

echo 'Starting nginx..'
/etc/init.d/nginx start

echo 'Starting php-fpm...'
/etc/init.d/php7.4-fpm start

echo 'Running queue...'
php /var/www/html/artisan queue:work --tries=2 &

echo 'Ready to serve...'
tail -f /var/www/html/storage/logs/lumen.log
