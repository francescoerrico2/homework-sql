FROM php:5.6-apache

RUN docker-php-ext-install mysqli

COPY ./login.php /var/www/html/
COPY ./welcome.php /var/www/html/
COPY ./init.sql /docker-entrypoint-initdb.d/
COPY ./logout.php /var/www/html/
