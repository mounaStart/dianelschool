# Étape 1: Image de base
FROM php:8.2-apache

# Étape 2: Installation des dépendances système
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libgd-dev \
        curl \
        libpq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Étape 3: Installation des extensions PHP (optimisé pour PostgreSQL)
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache && \
    docker-php-ext-enable opcache

# Étape 4: Configuration Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Étape 5: Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 6: Configuration du workspace
WORKDIR /var/www/html

# Étape 7: Permissions Laravel (optimisées)
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Étape 8: Installation des dépendances
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Étape 9: Copie de l'application
COPY --chown=www-data:www-data . .

# Étape 10: Configuration Laravel (séparée et sécurisée)
# Génération de la clé d'application seulement si .env n'existe pas
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        php artisan key:generate --no-interaction; \
    fi

# Étape 11: Commandes artisan exécutées séparément avec gestion d'erreur
RUN php artisan storage:link --quiet && \
    php artisan config:clear --quiet && \
    php artisan view:clear --quiet && \
    php artisan route:clear --quiet && \
    php artisan cache:clear --quiet && \
    (php artisan optimize || true)

# Étape 12: Exposition des ports
EXPOSE 80

# Étape 13: Commande de démarrage optimisée
CMD ["sh", "-c", \
    "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    php artisan config:cache && \
    php artisan view:cache && \
    apache2-foreground"]
