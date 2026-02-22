FROM php:8.1-fpm
 RUN apt update && apt install -y \
 zip unzip git \
 libzip-dev \
 libpng-dev \
 libonig-dev \
 libxml2-dev \
 && docker-php-ext-install pdo pdo_mysql zip
 COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
 WORKDIR /var/www/html