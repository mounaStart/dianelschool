# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires à Laravel pour PostgreSQL
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev libxml2-dev libgd-dev curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd

# Active le module Apache pour la réécriture d'URL
RUN a2enmod rewrite

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le contenu du projet Laravel dans le container
COPY . /var/www/html

# Définit le répertoire de travail
WORKDIR /var/www/html

# Donne les permissions avant d’installer les dépendances
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Installe les dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Vérifie que le dossier vendor a bien été créé
RUN test -d vendor || (echo "Vendor folder missing!" && exit 1)

# Génère le fichier .env si absent et la clé d'application
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate

# Redonne les droits aux dossiers
RUN chmod -R 775 storage bootstrap/cache

# Configuration Apache pour pointer sur le dossier public
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose le port 80
EXPOSE 80

# (Optionnel) Affiche les logs d'erreurs Laravel si existants
RUN if [ -f storage/logs/laravel.log ]; then \
        echo "===== DÉBUT LOG LARAVEL =====" && \
        tail -n 50 storage/logs/laravel.log && \
        echo "===== FIN LOG LARAVEL ====="; \
    else \
        echo "Aucun fichier de log Laravel trouvé."; \
    fi
