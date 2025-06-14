# Étape 1 : Construction de l'environnement PHP
FROM php:8.2-apache AS builder

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install \
    pdo pdo_mysql pdo_pgsql \
    mbstring zip exif pcntl bcmath

# Configurer Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Créer et configurer le répertoire de travail
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Étape 2 : Installation des dépendances avec cache optimisé
FROM builder AS dependencies

# Copier uniquement les fichiers nécessaires pour composer
COPY composer.json composer.lock ./

# Installer les dépendances (sans scripts pour éviter l'erreur artisan)
RUN composer install --no-interaction --prefer-dist --no-scripts --no-autoloader

# Étape 3 : Construction finale
FROM builder AS final

# Copier les dépendances installées
COPY --from=dependencies /var/www/html/vendor /var/www/html/vendor

# Copier le reste de l'application
COPY . .

# Générer l'autoloader et exécuter les scripts artisan
RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && php artisan optimize:clear

# Configurer l'environnement Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && chmod -R 775 storage bootstrap/cache

# Exposer le port et démarrer Apache
EXPOSE 80
CMD ["apache2-foreground"]
