FROM php:8.1.8-fpm

RUN apt-get update && apt-get install -y curl zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

