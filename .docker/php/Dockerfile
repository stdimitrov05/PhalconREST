FROM composer:latest as composer
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/php

ENV PHALCON_VERSION="5.1.4" \
    PHP_VERSION="8.1"

# Update
RUN apt update -y && \
    apt install -y \
        gettext \
        libzip-dev \
        zip

# PECL Packages
RUN pecl install -o -f redis && \
    pecl install phalcon-${PHALCON_VERSION}  \
      xdebug

# Install PHP extensions
RUN docker-php-ext-install \
      gettext \
      pdo_mysql \
      zip

# Install PHP extensions
RUN docker-php-ext-enable \
      opcache \
      phalcon \
      redis \
      xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Bash script with helper aliases
COPY ./.bashrc /root/.bashrc
COPY ./.bashrc /home/phalcon/.bashrc

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]