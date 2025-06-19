# Étape 1 : Base image avec PHP et Apache
FROM php:8.2-apache

# Étape 2 : Définir les variables d'environnement
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    APACHE_DOCUMENT_ROOT=/var/www/html/public \
    DEBIAN_FRONTEND=noninteractive

# Étape 3 : Configuration système de base
RUN apt-get clean && \
    apt-get update -y --fix-missing && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        zip \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
        libonig-dev \
        libxml2-dev \
        libgd-dev \
        curl \
        ca-certificates \
        libpq-dev \
        supervisor \
    && rm -rf /var/lib/apt/lists/*

# Étape 4 : Installer les extensions PHP nécessaires
RUN docker-php-ext-configure gd --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd \
        opcache

# Étape 5 : Configurer Apache
RUN a2enmod rewrite headers && \
    sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Étape 6 : Installer Composer globalement
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 7 : Créer le répertoire de l'application et définir les permissions
RUN mkdir -p /var/www/html && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Étape 8 : Copier les fichiers de configuration séparément pour mieux utiliser le cache Docker
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Étape 9 : Copier les fichiers de l'application
WORKDIR /var/www/html
COPY . .

# Étape 10 : Installer les dépendances Composer (en excluant les dépendances de développement en production)
RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader; \
    else \
        composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi

# Étape 11 : Configurer l'application Laravel
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        php artisan key:generate; \
    fi && \
    php artisan storage:link && \
    php artisan optimize:clear

# Étape 12 : Nettoyer les fichiers inutiles
RUN if [ "$APP_ENV" = "production" ]; then \
        composer clear-cache && \
        rm -rf /tmp/* /var/tmp/* /usr/share/doc/*; \
    fi

# Étape 13 : Exposer le port et définir le CMD
EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
