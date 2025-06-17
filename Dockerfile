# Étape 1: Image de base
FROM php:8.2-apache

# Étape 2: Installation des dépendances système (en une seule commande RUN)
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

# Étape 3: Installation des extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pgsql \
    pdo_pgsql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    opcache

# Étape 4: Configuration Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Configuration du ServerName pour éviter l'avertissement Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Étape 5: Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 6: Configuration du workspace
WORKDIR /var/www/html

# Étape 7: Permissions Laravel (AMÉLIORATION)
# Création des répertoires avec le bon propriétaire dès le début
RUN mkdir -p storage/framework/{sessions,views,cache} && \
    mkdir -p storage/logs && \
    mkdir -p bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage && \
    chown -R www-data:www-data /var/www/html/bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chmod -R 777 storage/logs

# Étape 8: Installation des dépendances
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Étape 9: Copie de l'application avec les bonnes permissions
COPY --chown=www-data:www-data . .

# Étape 10: Configuration Laravel (AMÉLIORATION)
# Exécution des commandes artisan avec l'utilisateur www-data
RUN if [ ! -f .env ]; then cp .env.example .env && chown www-data:www-data .env; fi && \
    php artisan key:generate && \
    php artisan storage:link && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan cache:clear && \
    (php artisan optimize || true) && \
    chown -R www-data:www-data /var/www/html

# Étape 11: Exposition des ports
EXPOSE 80

# Démarrage avec les bonnes permissions
CMD ["sh", "-c", "chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && apache2-foreground"]
