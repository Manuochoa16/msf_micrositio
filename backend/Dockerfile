# Imagen base de PHP con Apache
FROM php:8.2-apache

# Habilitar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar los archivos del proyecto al directorio de Apache
COPY . /var/www/html

# Copiar archivo de configuración de Apache
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar la exposición del puerto
EXPOSE 80

# Configurar el inicio de Apache
CMD ["apache2-foreground"]
