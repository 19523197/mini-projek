#!/bin/bash

sed -i -- "s/WORKER_PROCESSES_ENV/$WORKER_PROCESSES/g; \
    s/WORKER_CONNECTIONS_ENV/$WORKER_CONNECTIONS/g; \
    s/PHP_MAX_UPLOAD_SIZE_ENV/$PHP_MAX_UPLOAD_SIZE/g; \
    s/MAX_EXECUTION_TIME_ENV/$MAX_EXECUTION_TIME/g" /etc/nginx/nginx.conf

echo "" >> /etc/php/7.4/fpm/pool.d/www.conf
echo "pm.max_children = $PM_MAX_CHILDREN" >> /etc/php/7.4/fpm/pool.d/www.conf
echo "php_admin_value[memory_limit] = $PHP_MEMORY_LIMIT" >> /etc/php/7.4/fpm/pool.d/www.conf
echo "php_admin_value[upload_max_filesize] = $PHP_MAX_UPLOAD_SIZE" >> /etc/php/7.4/fpm/pool.d/www.conf
echo "php_admin_value[post_max_size] = $PHP_MAX_UPLOAD_SIZE" >> /etc/php/7.4/fpm/pool.d/www.conf
echo "php_admin_value[max_execution_time] = $MAX_EXECUTION_TIME" >> /etc/php/7.4/fpm/pool.d/www.conf
