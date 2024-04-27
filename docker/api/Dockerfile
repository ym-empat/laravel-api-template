FROM php:8.3.6-fpm AS base

# Install system packages
RUN apt-get update -y && apt-get install -y \
    zip unzip zlib1g-dev jpegoptim optipng \
    pngquant gifsicle webp libzip-dev git \
    libicu-dev libpng-dev libjpeg-dev libfreetype-dev 

# Install php extensions
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install pcntl \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip

# Install intl for currencies
RUN docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Install composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

# Prepare for local dev work
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www