# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Variables d'environnement
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public \
    COMPOSER_ALLOW_SUPERUSER=1

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# Configuration d'Apache
RUN a2enmod rewrite && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configuration des permissions
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www && \
    mkdir -p storage/framework/{cache,sessions,testing,views} && \
    mkdir -p bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Copie des fichiers (d'abord seulement ce dont Composer a besoin)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts

# Copie du reste de l'application
COPY . .

# Exécution des scripts Composer et configuration Laravel
RUN composer dump-autoload --optimize && \
    [ -f .env ] || cp .env.example .env && \
    php artisan key:generate && \
    php artisan storage:link

# Port exposé
EXPOSE 80
