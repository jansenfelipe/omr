FROM php:7.0-cli-alpine

RUN apk add -u $PHPIZE_DEPS \
    git \
    imagemagick6 \
    imagemagick6-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install imagick-3.4.2 \
    && docker-php-ext-enable imagick

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.remote_autostart=1" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    echo "xdebug.remote_enable=1" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null && \
    if ping -c 1 docker.for.mac.localhost > /dev/null; \
    then \
        echo "xdebug.remote_host=docker.for.mac.localhost" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null; \
    else \
        echo "xdebug.remote_host=`/sbin/ip route|awk '/default/ { print $3 }'`" | tee -a /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini > /dev/null; \
    fi