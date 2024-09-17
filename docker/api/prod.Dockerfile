FROM node:22.2.0-slim AS nodejs

FROM php:8.3-fpm AS base

# Arguments
ARG NOVA_USER
ARG NOVA_TOKEN

# Test for required arguments
RUN test -n "$NOVA_USER" || (echo "NOVA_USER is not set" && false)
RUN test -n "$NOVA_TOKEN" || (echo "NOVA_TOKEN is not set" && false)

# Copy Node.js & NPM
COPY --from=nodejs /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=nodejs /usr/local/bin/node /usr/local/bin/node

RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

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

# Copy the application files
COPY ./ /var/www/html/
COPY ./docker/api/.bashrc /home/www/.bashrc
COPY ./docker/api/php.ini /usr/local/etc/php/php.ini

# Set the working directory
WORKDIR /var/www/html

RUN cp .env.example .env

# Install composer dependencies
RUN composer config http-basic.nova.laravel.com "$NOVA_USER" "$NOVA_TOKEN"
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

RUN chown www:www ./ -R && chmod 775 ./ -R

USER www

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]