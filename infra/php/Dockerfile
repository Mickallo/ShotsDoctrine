FROM php:8.2-fpm

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql
# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code de l'application
WORKDIR /var/www/html
COPY . .

# Exposer le port 9000 et démarrer PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
