FROM php:8.3-apache

RUN apt-get update && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html

CMD ["apache2-foreground"]