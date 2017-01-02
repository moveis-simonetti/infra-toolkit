FROM php:7-apache

ENV http_proxy ${http_proxy}
ENV https_proxy ${http_proxy}

RUN apt-get update && apt-get install -y zip \
        libfreetype6-dev \
        libmcrypt-dev \
        git \
        libxslt-dev \
    && docker-php-ext-install -j$(nproc) zip soap

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

CMD usermod -u 1000 www-data \
    && cd /var/www/html && composer install && apache2-foreground