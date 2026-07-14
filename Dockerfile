FROM php:8.3-apache

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2dismod mpm_event || true && \
    a2dismod mpm_worker || true && \
    a2enmod mpm_prefork && \
    a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html

CMD ["apache2-foreground"]