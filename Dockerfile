FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev unzip git libzip-dev libonig-dev libpng-dev libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo_pgsql zip mbstring gd

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN echo "date.timezone = America/Rio_branco" > /usr/local/etc/php/conf.d/timezone.ini

COPY . .

RUN chown -R www-data:www-data /var/www/html
