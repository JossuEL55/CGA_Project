# Imagen base con PHP, Composer y extensiones necesarias
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia archivos del proyecto
WORKDIR /var/www
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajustes de permisos
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Expone puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000
