FROM php:7.2-apache
RUN apt-get update -y

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

# Add correct rights for www folder.
RUN chown -R www-data:www-data /var/www/

# Install and enable xdebug.

COPY . /var/www/html/
