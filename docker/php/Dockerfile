FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libpq-dev \
        wget \
        zlib1g-dev \
        libmcrypt-dev \
        libzip-dev \
        librabbitmq-dev

RUN apt-get install -y git \
    bash \
    unzip

RUN docker-php-ext-install pdo pdo_pgsql \
    sockets \
    zip

RUN pecl channel-update pecl.php.net && pecl install amqp-2.1.2 && pecl install xdebug-3.1.6

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Allow Composer to use all available RAM while installing packages

CMD ["php-fpm"]