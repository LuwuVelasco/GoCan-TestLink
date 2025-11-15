FROM php:7.4-apache

# Instalar extensiones necesarias para TestLink
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    mysql-client \
    postgresql-client \
    git \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    zip \
    mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Copiar archivos de TestLink al DocumentRoot
COPY . /var/www/html/

# Crear directorio de logs
RUN mkdir -p /var/www/html/logs && chmod -R 777 /var/www/html/logs
RUN mkdir -p /var/www/html/upload_area && chmod -R 777 /var/www/html/upload_area
RUN mkdir -p /var/www/html/gui/templates_c && chmod -R 777 /var/www/html/gui/templates_c

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
