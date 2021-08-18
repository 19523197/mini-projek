FROM asia.gcr.io/uii-cloud-project/interoperability/os/php-server:lumen8-2

LABEL maintainer="Nabil Muhammad Firdaus <211232629@uii.ac.id>"

ARG IS_LOCAL="false"
ENV IS_LOCAL=$IS_LOCAL

COPY app /var/www/html/app/
COPY bootstrap /var/www/html/bootstrap/
COPY public /var/www/html/public/
COPY routes /var/www/html/routes/
COPY resources /var/www/html/resources/
COPY storage/logs /var/www/html/storage/logs/
COPY tests /var/www/html/tests/
COPY vendor /var/www/html/vendor/
COPY artisan /var/www/html/
#COPY docker/env.sh /root/env.sh
COPY docker/setup.sh /root/setup.sh
COPY docker/build-conf.sh /root/build-conf.sh
COPY docker/entrypoint.sh /root/entrypoint.sh
#COPY .env.prod /var/www/html/

RUN chmod +x /root/setup.sh \
    && chmod +x /root/build-conf.sh \
    && chmod +x /root/entrypoint.sh \
    && /root/setup.sh

RUN chown -R nobody.www-data /var/www/html/

ENTRYPOINT ["/root/entrypoint.sh"]
