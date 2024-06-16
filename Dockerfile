# Use the official PHP image as base image
FROM php:8.0

# Set working directory inside the container
WORKDIR /var/www/html

# Install dependencies and configure GD extension
RUN apt-get update \
    && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Copy the rest of the application code
COPY . .

# Expose port 80 and CMD to run Apache or PHP server
EXPOSE 80
CMD ["apache2-foreground"]
