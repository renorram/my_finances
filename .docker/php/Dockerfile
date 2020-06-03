FROM php:7.4-fpm-alpine

RUN addgroup -g 1000 www \
    && adduser -D -u 1000 -G www www

RUN apk add --no-cache zlib-dev freetype-dev libzip-dev libjpeg-turbo-dev libpng-dev postgresql-dev icu-dev

RUN docker-php-ext-install opcache pdo_pgsql zip intl

RUN docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN curl -L https://cs.symfony.com/download/php-cs-fixer-v2.phar -o php-cs-fixer \
    && chmod a+x php-cs-fixer \
    && mv php-cs-fixer /usr/bin/php-cs-fixer

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del --no-network


USER www
