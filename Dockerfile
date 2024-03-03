FROM php:8.2.0-fpm-alpine3.16

RUN apk add --no-cache openssl bash mysql-client shadow libzip-dev nodejs npm sqlite-dev \
    freetype less libjpeg-turbo libpng freetype-dev libjpeg-turbo-dev libpng-dev \
    autoconf g++ make linux-headers

RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite zip pcntl posix

RUN docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN wget https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-alpine-linux-amd64-v0.6.1.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-alpine-linux-amd64-v0.6.1.tar.gz \
    && rm dockerize-alpine-linux-amd64-v0.6.1.tar.gz

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN chown -R www-data:www-data /var/www
RUN ln -s public html
RUN usermod -u 1000 www-data

USER www-data

EXPOSE 9000
ENTRYPOINT ["php-fpm"]
