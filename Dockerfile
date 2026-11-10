# Imagen de PHP con Apache, MySQL (mysqli) e imágenes (gd con JPEG y WebP)
FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Más memoria para procesar portadas grandes
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory.ini
