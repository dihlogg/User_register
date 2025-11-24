FROM php:8.2-apache

# Cài các extension
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

# Copy cấu hình PHP
COPY php.ini /usr/local/etc/php/