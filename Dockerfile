FROM php:7.4-apache
RUN pecl install APCu-5.1.18
RUN docker-php-ext-enable apcu

WORKDIR /var/www/html/
COPY ./ /var/www/html/

