FROM asia.gcr.io/uii-cloud-project/uii-gateway/backend/os/php-server:8.0

LABEL maintainer="Nabil Muhammad Firdaus <211232629@uii.ac.id>"

ARG IS_LOCAL="false"
ENV IS_LOCAL $IS_LOCAL

COPY config /var/www/html/config/
COPY resources /var/www/html/resources/
COPY src /var/www/html/src/
COPY tests /var/www/html/tests/
COPY vendor /var/www/html/vendor/

RUN /root/local-setup.sh
