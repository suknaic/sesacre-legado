FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev unzip git libzip-dev libonig-dev libpng-dev libjpeg-dev curl \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install pdo_pgsql zip mbstring gd bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN echo "date.timezone = America/Rio_branco" > /usr/local/etc/php/conf.d/timezone.ini

RUN useradd -G www-data,root -u 1000 -d /home/sesacre sesacre \
    && mkdir -p /home/sesacre/.composer \
    && chown -R sesacre:sesacre /home/sesacre

USER sesacre
