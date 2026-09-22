FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    zip \
    git \
    && docker-php-ext-install intl pdo pdo_mysql

RUN a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN git config --global --add safe.directory /var/www/html

RUN composer install

RUN chown -R www-data:www-data /var/www/html/tmp /var/www/html/logs

EXPOSE 80