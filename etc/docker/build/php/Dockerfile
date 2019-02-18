FROM php:7.2-fpm

MAINTAINER elantha <grizmar5@gmail.com>

RUN usermod -u 1000 www-data

RUN apt-get update \
    && apt-get install -y \
    ca-certificates \
    curl \
    sudo \
    dbview \
    git \
    wget \
    vim \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libxslt-dev \
    libicu-dev \
    libpng-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install -j$(nproc) pgsql pdo_pgsql \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-install xsl \
    && docker-php-ext-install zip

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www/

CMD ["php-fpm"]