#!/bin/sh

if [ ! -f '/var/www/html/.env' ]; then
    cp /var/www/html/.env.deploy /var/www/html/.env
fi
