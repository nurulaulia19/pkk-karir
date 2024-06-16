# Gunakan image base dari PHP dengan Apache
FROM php:8.1-apache

# Mengatur direktori kerja
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Menginstal Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Salin file Laravel dan install dependensi
COPY . /var/www/html
RUN composer install --ignore-platform-req=ext-zip

# Set izin file
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Konfigurasi Apache untuk Laravel
COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Command untuk menjalankan Apache
CMD ["apache2-foreground"]
