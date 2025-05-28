 # Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# Installe les extensions PHP nécessaires à Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev zip libpng-dev libonig-dev libxml2-dev libgd-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Active le module Apache pour réécriture d'URL
RUN a2enmod rewrite

# Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copie le contenu du projet Laravel
COPY . /var/www/html

# Définit le répertoire de travail
WORKDIR /var/www/html

# Donne les permissions nécessaires AVANT composer install
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Installe les dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Vérifie que le dossier vendor a bien été créé
RUN test -d vendor || (echo "Vendor folder missing!" && exit 1)

# Copie .env et génère la clé Laravel (APRÈS composer install)
#RUN cp .env.example .env && php artisan key:generate

# Crée .env à partir de .env.example si non présent
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate
    
# Redonne les droits après la génération de la clé (par sécurité)
RUN chmod -R 775 storage bootstrap/cache

# Configuration Apache pour pointer vers /public
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose le port Apache
EXPOSE 80

# 🔎 Affiche les dernières erreurs Laravel dans les logs si elles existent
RUN if [ -f storage/logs/laravel.log ]; then \
        echo "===== DÉBUT LOG LARAVEL =====" && \
        tail -n 50 storage/logs/laravel.log && \
        echo "===== FIN LOG LARAVEL ====="; \
    else \
        echo "Aucun fichier de log Laravel trouvé."; \
    fi
