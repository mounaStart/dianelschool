# Étape 1: Image de base PHP 8.2 avec Apache
FROM php:8.2-apache

# Étape 2: Installation des dépendances
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        postgresql-client && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Étape 3: Extensions PHP nécessaires
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    bcmath \
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

# Étape 7: Permissions Laravel
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Étape 8: Installation des dépendances
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Étape 9: Copie de l'application
COPY --chown=www-data:www-data . .

# Étape 10: Configuration .env (version sécurisée)
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        echo "APP_KEY=" >> .env && \
        echo "DB_SSLMODE=require" >> .env && \
        echo "DB_SSL=true" >> .env && \
        chown www-data:www-data .env && \
        chmod 640 .env; \
    fi

# Étape 11: Commandes artisan séparées avec gestion d'erreur
RUN php artisan config:clear --no-interaction || \
    echo "Config clear failed but continuing..."
RUN php artisan view:clear --no-interaction || \
    echo "View clear failed but continuing..."
RUN php artisan route:clear --no-interaction || \
    echo "Route clear failed but continuing..."
RUN php artisan cache:clear --no-interaction || \
    echo "Cache clear failed but continuing..."
RUN php artisan storage:link --no-interaction || \
    echo "Storage link failed but continuing..."
RUN php artisan optimize --no-interaction || \
    echo "Optimize failed but continuing..."

# Étape 12: Port exposé
EXPOSE 80

# Étape 13: Commande de démarrage
CMD ["sh", "-c", \
    "php artisan config:cache && \
     php artisan view:cache && \
     chown -R www-data:www-data /var/www/html/storage && \
     apache2-foreground"]
