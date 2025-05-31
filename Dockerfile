# Imagen base con PHP 8.2 y FPM
FROM php:8.2-fpm

# Instala dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Instala Composer desde la imagen oficial de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos del proyecto
COPY . .

# Instala dependencias PHP de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajusta permisos para Laravel (storage y bootstrap/cache)
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Expone el puerto 8000 para acceso a la app
EXPOSE 8000

# Comando por defecto para iniciar Laravel usando PHP built-in server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
