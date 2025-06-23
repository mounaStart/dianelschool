FROM php:8.2-apache

# Met à jour le système
RUN apt-get update && apt-get install -y \
    libpq-dev libjpeg-dev libpng-dev libfreetype6-dev libzip-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pgsql bcmath gd zip \
    && a2enmod rewrite

# Copier le binaire de composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier le code avant d’installer les dépendances
COPY ./app/ /var/www/html

# Copier les fichiers Composer
COPY composer.json composer.lock ./

# Installer les dépendances
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# Configurer les droits d'accès
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Vhost
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
