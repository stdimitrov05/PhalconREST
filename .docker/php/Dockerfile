# Use the composer:latest image as a build stage to install Composer
FROM composer:latest as composer

# Use the php:8.1-fpm image as the base image
FROM php:8.1-fpm

# Set the working directory to /var/www/php
WORKDIR /var/www/php

# Set the Phalcon version to 5.2.1 as an environment variable
ENV PHALCON_VERSION="5.2.1"

# Update the package manager and install necessary packages
RUN apt update -y && \
    apt install -y \
        gettext \
        libzip-dev \
        zip \
        libpng-dev \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libxpm-dev \
        libfreetype6-dev

# Install Redis and Phalcon extensions via PECL
RUN pecl install -o -f redis && \
    pecl install phalcon-${PHALCON_VERSION} xdebug

# Configure the GD extension with JPEG, WebP, XPM, and Freetype support
RUN docker-php-ext-configure gd \
    --prefix=/usr \
    --with-jpeg \
    --with-webp \
    --with-xpm \
    --with-freetype

# Install PHP extensions via the PHP extension installer
RUN docker-php-ext-install \
      gettext \
      pdo_mysql \
      zip \
      gd

# Enable PHP extensions
RUN docker-php-ext-enable \
      opcache \
      phalcon \
      redis \
      xdebug

# Clear cache and remove unnecessary files
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
# Bash script with helper aliases
COPY ./.bashrc /root/.bashrc
COPY ./.bashrc /home/phalcon/.bashrc

# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Bash script with helper aliases
COPY ./.bashrc /root/.bashrc
COPY ./.bashrc /home/phalcon/.bashrc


# Set the default command to run PHP-FPM
CMD ["php-fpm"]
