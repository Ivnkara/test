FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sSL https://phar.phpunit.de/phpunit-9.phar > /usr/local/bin/phpunit \
    && chmod +x /usr/local/bin/phpunit

RUN pecl install redis && docker-php-ext-enable redis

WORKDIR /var/www/html
