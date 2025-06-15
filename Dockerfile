# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# 1. Installe les dépendances système (avec libpq-dev pour PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libgd-dev \
    curl \
    libpq-dev \          # Nécessaire pour pdo_pgsql
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Installe les extensions PHP (avec opcache pour performance)
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache

# 3. Configure Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# 4. Installe Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Configure le répertoire de travail
WORKDIR /var/www/html

# 6. Crée les répertoires manquants et configure les permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 7. Copie les fichiers de l'application (en deux étapes pour optimiser le cache)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# 8. Copie le reste des fichiers
COPY . .

# 9. Exécute les scripts artisan
RUN composer run-script post-autoload-dump \
    && php artisan package:discover --ansi

# 10. Configure l'environnement Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate \
    && php artisan config:clear \
    && php artisan view:clear \
    && php artisan route:clear

# 11. Optimise les performances
RUN php artisan optimize

# 12. Configuration Apache alternative (si .docker/vhost.conf n'existe pas)
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# 13. Expose le port Apache
EXPOSE 80

# 14. Affiche les logs Laravel si existants (mode debug)
RUN if [ -f storage/logs/laravel.log ]; then \
        echo "===== DERNIÈRES ERREURS LARAVEL =====" && \
        tail -n 50 storage/logs/laravel.log && \
        echo "===================================="; \
    else \
        echo "Aucune erreur trouvée dans les logs."; \
    fi

# 15. Commande par défaut
CMD ["apache2-foreground"]
