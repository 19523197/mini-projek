FROM asia.gcr.io/uii-cloud-project/uii-gateway/backend/os/php-server:8.0

LABEL maintainer="Nabil Muhammad Firdaus <211232629@uii.ac.id>"

COPY config /var/www/html/config/
COPY resources /var/www/html/resources/
COPY src /var/www/html/src/
COPY tests /var/www/html/tests/
COPY vendor /var/www/html/vendor/
COPY composer.lock /var/www/html/
COPY composer.json /var/www/html/

RUN set -eux; \
    curl -sS https://getcomposer.org/installer | php; \
    mv composer.phar /usr/local/bin/; \
    ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
