# Partir d'une image PHP + Apache
FROM php:8.2-apache

# Installer les dépendances PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Activer le mod_rewrite d'Apache
RUN a2enmod rewrite

# Copier le vhost personnalisé
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copier le code de l'app dans le container
COPY ./app/ /var/www/html/

# Configurer les droits
RUN chown -R www-data:www-data /var/www/html

# Nettoyage
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Exposer le port
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
