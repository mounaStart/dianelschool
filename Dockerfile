FROM php:8.2-apache

# 1. Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. Installation des extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    zip \
    bcmath \
    opcache \
    && docker-php-ext-enable opcache

# 3. Configuration Apache
RUN a2enmod rewrite
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 4. Installation de Composer (version stable)
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 5. Configuration du workspace
WORKDIR /var/www/html

# 6. Installation des dépendances COMPOSER (version corrigée)
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts

# 7. Configuration des permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 8. Copie de l'application
COPY --chown=www-data:www-data . .

# 9. Configuration .env minimal
RUN if [ ! -f .env ]; then \
    cp .env.example .env \
    && echo "APP_KEY=" >> .env \
    && echo "DB_SSLMODE=require" >> .env \
    && chown www-data:www-data .env \
    && chmod 640 .env; \
    fi

# 10. Commandes artisan essentielles seulement
RUN php artisan config:clear --no-interaction
RUN php artisan cache:clear --no-interaction

EXPOSE 80

CMD ["sh", "-c", \
    "php artisan config:cache \
    && chown -R www-data:www-data storage \
    && apache2-foreground"]
