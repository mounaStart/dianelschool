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
    echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot ${APACHE_DOCUMENT_ROOT}\n\
    \n\
    <Directory ${APACHE_DOCUMENT_ROOT}>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    \n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf && \
    sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Étape 6 : Configurer OPcache
RUN echo '[opcache]\n\
opcache.enable=1\n\
opcache.memory_consumption=128\n\
opcache.max_accelerated_files=10000\n\
opcache.revalidate_freq=60\n\
' > /usr/local/etc/php/conf.d/opcache.ini

# Étape 7 : Configurer Supervisor
RUN echo '[supervisord]\n\
nodaemon=true\n\
logfile=/var/log/supervisor/supervisord.log\n\
pidfile=/var/run/supervisord.pid\n\
\n\
[program:apache2]\n\
command=/usr/sbin/apache2ctl -D FOREGROUND\n\
autostart=true\n\
autorestart=true\n\
stderr_logfile=/var/log/apache2/error.log\n\
stdout_logfile=/var/log/apache2/access.log\n\
\n\
[program:cron]\n\
command=/usr/sbin/cron -f\n\
autostart=true\n\
autorestart=true\n\
' > /etc/supervisor/conf.d/supervisord.conf

# Étape 8 : Installer Composer globalement
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 9 : Créer le répertoire de l'application et définir les permissions
RUN mkdir -p /var/www/html && \
    chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Étape 10 : Copier les fichiers de l'application
WORKDIR /var/www/html
COPY . .

# Étape 11 : Installer les dépendances Composer
RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader; \
    else \
        composer install --no-interaction --prefer-dist --optimize-autoloader; \
    fi

# Étape 12 : Configurer l'application Laravel
RUN if [ ! -f .env ]; then \
        cp .env.example .env && \
        php artisan key:generate; \
    fi && \
    php artisan storage:link && \
    php artisan optimize:clear

# Étape 13 : Nettoyer les fichiers inutiles
RUN if [ "$APP_ENV" = "production" ]; then \
        composer clear-cache && \
        rm -rf /tmp/* /var/tmp/* /usr/share/doc/*; \
    fi

# Étape 14 : Exposer le port et définir le CMD
EXPOSE 80
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
