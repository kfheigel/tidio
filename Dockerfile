ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    nano \
    librabbitmq-dev

RUN apt-get install -y --no-install-recommends \
    postgresql-client \
    libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql 

RUN pecl install amqp \
    && docker-php-ext-enable amqp

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN git clone https://github.com/xdebug/xdebug.git
RUN cd xdebug && phpize && ./configure && make && make install

COPY docker/php/php-xdebug.ini /usr/local/etc/php/php.ini
COPY docker/nginx/conf.d/default.conf etc/nginx/conf.d

WORKDIR /app
