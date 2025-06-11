# Gebruik officiële PHP image met Apache
FROM php:8.2-apache

# Installeer systeemafhankelijkheden en PHP-extensies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git \
    && docker-php-ext-install pdo pdo_mysql zip

# Installeer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Stel werkmap in
WORKDIR /var/www/html

# Kopieer projectbestanden
COPY . .

# Pas rechten aan (voor Laravel storage en cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Stel de juiste public root in voor Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Pas Apache-config aan zodat /public de root is
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Laravel-vriendelijke instellingen
RUN a2enmod rewrite

# Installeer PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Node installeren (bijv. via multi-stage)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    npm install && npm run build

# Laravel cache opschonen (zonder .env check)
RUN php artisan config:clear || true
RUN php artisan route:clear || true

# Database migraten voor cache errors
RUN php artisan migrate --force

# Maak storage directories aan en geef de juiste rechten
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 775 storage \
    && chown -R www-data:www-data storage bootstrap/cache

# Stel poort in
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
