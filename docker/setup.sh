#!/bin/bash

if [ "$IS_LOCAL" = "true" ]; then
    apt update && apt install -y \
            curl \
            iputils-ping \
            dnsutils \
            php7.4-zip \
            zip \
            libzip-dev \
        && rm -rf /var/lib/apt/lists/* \
        && curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
fi
