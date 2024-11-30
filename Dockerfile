FROM php:8.1-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install zip pdo pdo_mysql

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite

# Configurar PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Configurar límites de PHP
RUN echo "upload_max_filesize = 64M" >> "$PHP_INI_DIR/php.ini" \
    && echo "post_max_size = 64M" >> "$PHP_INI_DIR/php.ini" \
    && echo "max_execution_time = 300" >> "$PHP_INI_DIR/php.ini" \
    && echo "max_input_time = 300" >> "$PHP_INI_DIR/php.ini"

# Configurar el DocumentRoot de Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Crear directorio public
RUN mkdir -p /var/www/html/public

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . /var/www/html/

# Mover archivos PHP a public
RUN mv /var/www/html/*.php /var/www/html/public/ || true

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Puerto por defecto de Apache
EXPOSE 80
