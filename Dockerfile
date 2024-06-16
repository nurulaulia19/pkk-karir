# Use the official PHP image as base image
FROM php:8.0

# Set working directory inside the container
WORKDIR /var/www/html

# Install dependencies and configure GD extension
RUN apt-get update --fix-missing \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip
