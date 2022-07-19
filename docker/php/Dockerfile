FROM php:8.1.0-fpm

ARG XDEBUG_VERSION="3.0.3"
# Install packages and PHP extensions
RUN apt update \
    && apt install -y git acl openssl openssh-client wget zip vim librabbitmq-dev libssh-dev \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev  sendmail\
    && docker-php-ext-install intl pdo pdo_mysql zip soap bcmath sockets \
    && yes '' | pecl install -f xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache xdebug

# Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

# Install PHP-CS-FIXER
RUN wget https://cs.symfony.com/download/php-cs-fixer-v2.phar -O php-cs-fixer
RUN chmod a+x php-cs-fixer
RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer

RUN mkdir -p /appdata/www

# Config XDEBUG
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /appdata/www
