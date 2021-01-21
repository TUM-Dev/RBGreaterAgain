FROM alpine:3 as npm
WORKDIR /app
RUN apk add npm
COPY ./package.json /app
COPY ./package-lock.json /app
# templates are needed in order to compile css
COPY ./tmpl /app/tmpl
# TODO find a way of avaoiding --unsafe-perm
RUN npm i --no-dev --unsafe-perm

FROM composer:latest as composer
COPY ./composer.json /app
COPY ./composer.lock /app
RUN composer install --no-dev

FROM php:7.4-apache
RUN pecl install APCu-5.1.18
RUN docker-php-ext-enable apcu
RUN a2enmod rewrite

WORKDIR /var/www/html/
COPY ./ /var/www/html/
COPY --from=npm /app/node_modules ./node_modules

COPY --from=composer /app/vendor ./vendor
