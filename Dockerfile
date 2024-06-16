# Gunakan base image PHP yang sesuai
FROM php:8.0-apache

# Install dependensi yang diperlukan
RUN apt-get update \
    && apt-get install -y libpng-dev \
                          libjpeg-dev \
                          libfreetype6-dev \
                          zip \
                          unzip \
                          git \
                          libzip-dev \
                          zlib1g-dev

# Install ekstensi PHP zip
RUN docker-php-ext-install zip

# Konfigurasi lainnya dan setup aplikasi Laravel bisa ditambahkan setelah ini
