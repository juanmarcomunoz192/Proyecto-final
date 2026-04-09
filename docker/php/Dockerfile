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

 # Instalamos Xdebug
 RUN pecl install xdebug && docker-php-ext-enable xdebug

 # Metemos la configuración en el archivo .ini
 RUN echo "zend_extension=xdebug" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
     && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
     && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

 RUN chown -R www-data:www-data /var/www/html