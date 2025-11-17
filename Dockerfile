FROM php:7.4-apache

# Extensiones que TestLink necesita (y Postgres)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    mbstring \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Directorio donde Apache sirve los archivos
WORKDIR /var/www/html

# Copiar todo el código de TestLink al DocumentRoot
COPY . /var/www/html

# Directorios de logs y adjuntos que usa tu config.inc.php
RUN mkdir -p /var/testlink/logs /var/testlink/upload_area \
 && chown -R www-data:www-data /var/www/html /var/testlink \
 && chmod -R 755 /var/testlink

# Mostrar errores mientras estamos configurando (luego lo puedes comentar)
RUN { \
      echo "display_errors=On"; \
      echo "display_startup_errors=On"; \
      echo "error_reporting=E_ALL"; \
    } > /usr/local/etc/php/conf.d/testlink-dev.ini

EXPOSE 80
CMD ["apache2-foreground"]