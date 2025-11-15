FROM php:7.4-apache

# Instalar extensiones necesarias para TestLink
RUN apt-get update && apt-get install -y \
    libzip-dev \
    default-mysql-client \
    git \
    curl \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
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

# Copiar script de inicio
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Establecer permisos
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80

# Ejecutar script de inicio
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
