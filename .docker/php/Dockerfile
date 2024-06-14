# Composer (use on local dev only)
FROM composer:latest as composer

FROM php:8.3.1-fpm

ENV PHALCON_VERSION=5.7.0 \
    EXT_REDIS_VERSION=6.0.2 \
    EXT_IGBINARY_VERSION=3.2.15

# Update
RUN apt update -y && \
    apt install -y \
        gettext \
        libzip-dev \
        zip \
        libicu-dev

RUN docker-php-source extract \
    # igbinary
    && mkdir -p /usr/src/php/ext/igbinary \
    &&  curl -fsSL https://github.com/igbinary/igbinary/archive/$EXT_IGBINARY_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/igbinary --strip 1 \
    && docker-php-ext-install igbinary \
    # redis
    && mkdir -p /usr/src/php/ext/redis \
    && curl -fsSL https://github.com/phpredis/phpredis/archive/$EXT_REDIS_VERSION.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && docker-php-ext-configure redis --enable-redis-igbinary \
    && docker-php-ext-install redis \
    # cleanup
    && docker-php-source delete

# PECL Packages
RUN pecl install phalcon-${PHALCON_VERSION}

# Install PHP extensions
RUN docker-php-ext-install \
      gettext \
      pdo_mysql \
      zip

# Enable PHP extensions
RUN docker-php-ext-enable phalcon

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer (use on local dev only)
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Bash script with helper aliases
COPY ./.bashrc /root/.bashrc

# Set working directory
WORKDIR /var/www/php

CMD ["php-fpm"]
