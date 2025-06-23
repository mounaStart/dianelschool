FROM php:8.2-apache


# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y libpq-dev libjpeg-dev libpng-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-install pdo_pgsql pgsql bcmath gd


# Copie du composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier les fichiers de dépendances en premier
WORKDIR /var/www/html
COPY composer.json composer.lock ./

# Installer les dépendances
RUN composer install --no-dev --optimize-autoloader

# Copier le reste du projet
COPY ./app/ /var/www/html

# Droits
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copie du vhost
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80
CMD ["apache2-foreground"]
