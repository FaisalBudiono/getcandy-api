FROM php:7.4-fpm
WORKDIR /var/www/html
RUN apt-get update \
    && apt-get install -y git zip
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer
# Install mcrypt PHP dependencies
RUN apt-get update \
    && apt-get install -y libmcrypt-dev libmagickwand-dev --no-install-recommends \
    && pecl install mcrypt \
    && docker-php-ext-enable mcrypt
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath
# Install zip PHP dependencies
RUN apt-get install -y libzip-dev \
    && docker-php-ext-install zip
# Set php.ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini