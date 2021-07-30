FROM php:8.0-fpm

RUN apt-get update

## development packages
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libzip-dev \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    vim \
    nano

## mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

## start with base php config, then add extensions
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN docker-php-ext-install \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    zip

# 4. composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG uid
RUN useradd -G www-data,root -u $uid -d /home/namttp namttp
RUN mkdir -p /home/namttp/.composer && \
    chown -R namttp:namttp /home/namttp