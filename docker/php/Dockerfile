FROM php:8.2-apache

# RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y libxslt-dev \
    && docker-php-ext-install xsl \
    && docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html