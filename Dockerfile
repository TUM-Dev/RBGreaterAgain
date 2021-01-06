FROM alpine:3 as npm
WORKDIR /app
RUN apk add npm
COPY ./package.json /app
COPY ./package-lock.json /app
RUN npm i --no-dev

FROM php:7.4-apache
RUN pecl install APCu-5.1.18
RUN docker-php-ext-enable apcu

WORKDIR /var/www/html/
COPY ./ /var/www/html/
COPY --from=npm /app/node_modules ./node_modules
