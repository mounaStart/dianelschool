# Utilise une image officielle PHP avec Apache
FROM php:8.2-apache

# 1. Installe les dépendances système (tout sur une seule ligne)
RUN apt-get update && apt-get install -y \
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

# 2. Installe les extensions PHP
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

# 6. Crée les répertoires et permissions
RUN mkdir -p storage/framework/{sessions,views,cache} && \
    mkdir -p bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# 7. Installation des dépendances Composer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# 8. Copie de l'application
COPY . .

# 9. Configuration Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate && \
    php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear && \
    php artisan optimize

# 10. Configuration Apache
RUN echo '<VirtualHost *:80>\
    DocumentRoot /var/www/html/public\
    <Directory /var/www/html/public>\
        AllowOverride All\
        Require all granted\
    </Directory>\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# 11. Port et commande
EXPOSE 80
CMD ["apache2-fore
