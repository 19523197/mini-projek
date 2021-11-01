#!/bin/sh

if [ "$IS_LOCAL" = "true" ]; then
    set -eux; \
#    apt-get update; \
#    apt-get install -y --no-install-recommends \
#        iputils-ping \
#        dnsutils \
#    ; \
#    rm -rf /var/lib/apt/lists/*; \
    curl -sS https://getcomposer.org/installer | php; \
    mv composer.phar /usr/local/bin/; \
    ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
fi
