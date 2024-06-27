#!/bin/bash

# Setup logging and cache directories
mkdir -p /var/log/nginx
mkdir -p /var/cache/nginx

# Install dependencies
composer install --ignore-platform-reqs
npm ci

# Build the project
npm run prod

# Start the server
vendor/bin/heroku-php-apache2 public/
