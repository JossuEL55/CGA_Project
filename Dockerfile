# ───────────────────────────────────────────────────────────
# Dockerfile
# ───────────────────────────────────────────────────────────

# 1. Partimos de la imagen base con PHP 8.2-FPM
FROM php:8.2-fpm

# 2. Instala dependencias del sistema necesarias (PostgreSQL, extensiones, etc.)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
 && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# 3. Copia Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Establece el directorio de trabajo en /var/www
WORKDIR /var/www

# 5. Copia todo el código de tu proyecto al contenedor
COPY . /var/www

# 6. Instala las dependencias PHP de Laravel (vendor/)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# 7. Ajusta permisos de carpetas que Laravel necesita modificar en tiempo de ejecución
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
 && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# 8. Expone el puerto 8000 (éste es el puerto en el que php artisan serve escuchará)
EXPOSE 8000

# 9. Al arrancar el contenedor, ejecuta migraciones y luego levanta el servidor Laravel
#    Usamos la forma "shell" de CMD para que se ejecuten múltiples comandos en secuencia.
#
#    a) php artisan session:table      → (solo si aún no existe la migración de sessions)
#    b) php artisan migrate --force    → aplica todas las migraciones (crea sesiones, clientes, plantas, etc.)
#    c) php artisan serve --host=0.0.0.0 --port=8000  → arranca el servidor incorporado de Laravel
#
#    IMPORTANTE: Si ya has generado manualmente la migración de sessions con `php artisan session:table`
#    en tu proyecto local y ese archivo está versionado en Git, entonces basta con `php artisan migrate --force`.
#    Mantengo el primer paso (`session:table`) solo en caso de que a futuro falte la migración.
#
CMD php artisan session:table \
    && php artisan migrate --force \
    && php artisan serve --host=0.0.0.0 --port=8000
