FROM php:8.2-apache
ARG DEBIAN_FRONTEND=noninteractive

# 1. Instalar dependencias del sistema y extensiones PHP necesarias para Symfony 7
RUN apt-get update && apt-get install -y \
    sendmail \
    libpng-dev \
    libzip-dev \
    zlib1g-dev \
    libonig-dev \
    libicu-dev \
    git \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql zip mbstring gd intl \
    && rm -rf /var/lib/apt/lists/*

# 2. Instalar Composer (necesario para gestionar paquetes dentro del contenedor)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Habilitar mod_rewrite para que funcionen las rutas de Symfony (.htaccess)
RUN a2enmod rewrite

# 4. Configurar Apache para que el DocumentRoot sea la carpeta /public de Symfony
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html
