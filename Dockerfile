# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libonig-dev libxml2-dev libpq-dev npm \
    && docker-php-ext-install pdo_pgsql mbstring zip xml

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Replace default site config with your Laravel-friendly one
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy env and generate app key
RUN cp .env.example .env && php artisan key:generate

# Install Node.js deps and build Vite assets
RUN npm install

RUN npm run build

# Set permissions for storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache
CMD php artisan migrate --force && apache2-foreground
