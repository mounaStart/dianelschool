# Étape 1: Image de base officielle PHP avec Apache
FROM php:8.2-apache

# Étape 2: Mise à jour et installation des dépendances système
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
        libpq-dev \
        postgresql-client && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Étape 3: Installation des extensions PHP nécessaires
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

# Étape 6: Configuration du répertoire de travail
WORKDIR /var/www/html

# Étape 7: Configuration des permissions Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Étape 8: Installation des dépendances Composer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev --no-scripts

# Étape 9: Copie de l'application avec les bonnes permissions
COPY --chown=www-data:www-data . .

# Étape 10: Configuration de l'environnement Laravel
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        chown www-data:www-data .env && \
        chmod 640 .env; \
    fi

# Étape 11: Configuration spécifique pour Render
RUN if [ -f .env ]; then \
        sed -i '/^DB_/d' .env && \
        echo "DB_CONNECTION=pgsql" >> .env && \
        echo "DB_SSLMODE=require" >> .env && \
        echo "DB_SSL=true" >> .env; \
    fi

# Étape 12: Nettoyage et optimisation
RUN php artisan config:clear --no-interaction && \
    php artisan view:clear --no-interaction && \
    php artisan route:clear --no-interaction && \
    php artisan cache:clear --no-interaction && \
    php artisan storage:link --no-interaction && \
    (php artisan optimize --no-interaction || true)

# Étape 13: Exposition du port
EXPOSE 80

# Étape 14: Commande de démarrage optimisée
CMD ["sh", "-c", \
    "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    php artisan config:cache --no-interaction && \
    php artisan view:cache --no-interaction && \
    apache2-foreground"]
