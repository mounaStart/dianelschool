# Étape 1: Image de base
FROM php:8.2-apache

# Étape 2: Installation des dépendances système (en une seule commande RUN)
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libgd-dev \
        curl \
        libpq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Étape 3: Installation des extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pgsql \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache

# Étape 4: Configuration Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Étape 5: Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 6: Configuration du workspace
WORKDIR /var/www/html

# Étape 7: Permissions Laravel (MODIFICATION ICI)
RUN mkdir -p storage/framework/{sessions,views,cache} && \
    mkdir -p storage/logs && \
    mkdir -p bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache && \
    chmod -R 777 storage/logs

# Étape 8: Installation des dépendances
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Étape 9: Copie de l'application
COPY . .

# Étape 10: Configuration Laravel (MODIFICATION ICI)
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    (php artisan optimize || true)

# Étape 11: Exposition des ports
EXPOSE 80
CMD ["apache2-foreground"]
