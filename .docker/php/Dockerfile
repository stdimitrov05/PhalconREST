FROM composer:latest as composer
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/php

ENV PHALCON_VERSION="5.2.1"

# Update
RUN apt update -y && \
    apt install -y \
        gettext \
        libzip-dev \
        zip \
        libpng-dev  \
        libwebp-dev  \
        libjpeg62-turbo-dev  \
        libxpm-dev  \
        libfreetype6-dev

# PECL Packages
RUN pecl install -o -f redis && \
    pecl install phalcon-${PHALCON_VERSION}  \
      xdebug

RUN docker-php-ext-configure gd \
    --prefix=/usr \
    --with-jpeg \
    --with-webp \
    --with-xpm \
    --with-freetype

# Install PHP extensions
RUN docker-php-ext-install \
      gettext \
      pdo_mysql \
      zip \
      gd

# Install PHP extensions
RUN docker-php-ext-enable \
      opcache \
      phalcon \
      redis \
      xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


CMD ["php-fpm"]
