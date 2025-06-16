# Étape 1: Utilise l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# Étape 2: Met à jour le système et installe les dépendances
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libgd-dev \
    curl \
    libpq-dev \          # Nécessaire pour PostgreSQL
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Étape 3: Installe les extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pgsql \              # Extension PostgreSQL native (manquante dans votre erreur)
    pdo_pgsql \          # PDO pour PostgreSQL
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache

# Étape 4: Active le module rewrite d'Apache
RUN a2enmod rewrite

# Étape 5: Configure le virtualhost Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Étape 6: Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 7: Configure le répertoire de travail
WORKDIR /var/www/html

# Étape 8: Crée les répertoires Laravel et configure les permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Étape 9: Copie et installe les dépendances Composer (avec gestion de l'erreur ext-pgsql)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Étape 10: Copie toute l'application
COPY . .

# Étape 11: Configure l'environnement Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && php artisan config:clear \
    && php artisan view:clear \
    && php artisan route:clear \
    && php artisan optimize

# Étape 12: Expose le port 80 et lance Apache
EXPOSE 80
CMD ["apache2-foreground"]
