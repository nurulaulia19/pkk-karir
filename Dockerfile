# Gunakan base image PHP yang sesuai
FROM php:8.0-apache

# Install dependensi yang diperlukan
RUN apt-get update \
    && apt-get install -y libpng-dev \
                          libjpeg-dev \
                          libfreetype6-dev \
                          zip \
                          unzip \
                          git

# Konfigurasi ekstensi gd untuk PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install ekstensi PHP secara terpisah
RUN docker-php-ext-install gd
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

# Konfigurasi lainnya dan setup aplikasi Laravel bisa ditambahkan setelah ini
