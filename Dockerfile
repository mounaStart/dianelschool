# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

# Active le module Apache pour réécriture d'URL
RUN a2enmod rewrite

# Installe Composer (gestionnaire de dépendances PHP)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le contenu de ton projet dans le dossier web de l'image
COPY . /var/www/html

# Définir le bon répertoire de travail
WORKDIR /var/www/html

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Installer les dépendances PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Générer la clé de l'application Laravel
#RUN php artisan key:generate

# Définir les permissions nécessaires à Laravel
RUN chmod -R 775 storage bootstrap/cache

# Expose le port Apache
EXPOSE 80
