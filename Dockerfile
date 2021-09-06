FROM asia.gcr.io/uii-cloud-project/academic/backend/os/php-server:8.0

LABEL maintainer="Nabil Muhammad Firdaus <211232629@uii.ac.id>"

ARG IS_LOCAL="false"
ENV IS_LOCAL=$IS_LOCAL

COPY app /var/www/html/app/
COPY bootstrap /var/www/html/bootstrap/
COPY public /var/www/html/public/
COPY routes /var/www/html/routes/
COPY resources /var/www/html/resources/
COPY storage/ /var/www/html/storage/
COPY tests /var/www/html/tests/
COPY vendor /var/www/html/vendor/
COPY artisan /var/www/html/
COPY docker/setup.sh /root/setup.sh
COPY .env.deploy /var/www/html/.env

RUN chmod +x /root/setup.sh && /root/setup.sh

RUN chown -R nobody.www-data /var/www/html/
