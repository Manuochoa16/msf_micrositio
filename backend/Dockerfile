# Imagen base de PHP con Apache
FROM php:8.2-apache

# Habilitar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al directorio de Apache
COPY . /var/www/html

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar la exposición del puerto
EXPOSE 80
