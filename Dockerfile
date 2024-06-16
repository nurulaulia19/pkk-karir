# Stage 1: Build aplikasi Laravel
FROM php:8.1-apache AS builder

# Install dependensi yang diperlukan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy aplikasi Laravel ke dalam container
COPY . .

# Install dependensi PHP dengan Composer
RUN composer install --ignore-platform-req=ext-zip

# Set izin file
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Stage 2: Deployment aplikasi Laravel
FROM php:8.1-apache

# Copy hasil build dari stage 1
COPY --from=builder /var/www/html /var/www/html

# Konfigurasi Apache untuk Laravel
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Command untuk menjalankan Apache
CMD ["apache2-foreground"]
