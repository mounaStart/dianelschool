FROM php:8.2-apache

# Mettre à jour le système et installer toutes les dépendances
RUN apt-get update && apt-get install -y \
    libpq-dev libjpeg-dev libpng-dev libfreetype6-dev libzip-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql bcmath gd zip \
    && a2enmod rewrite

# Copier le binaire de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers Composer
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Copier le reste du projet
COPY ./app/ /var/www/html

# Configurer les permissions sur le dossier
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copier le virtual host
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Exposer le port 80
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]
