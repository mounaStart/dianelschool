FROM php:8.2-apache

# Installations de base
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev \
    libxml2-dev libgd-dev curl libpq-dev && \
    docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql pdo_pgsql pgsql mbstring zip exif pcntl bcmath gd opcache

# Configure Apache
RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Préparation du dossier
RUN mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html

WORKDIR /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install dependencies first (optimize build cache)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --verbose

# Copy the rest
COPY . .

# Laravel setup
RUN test -f .env || cp .env.example .env \
    && php artisan key:generate \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80
