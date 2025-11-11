# ================================
# Moonlit Detailing - PHP Docker Image
# ================================
ARG PHP_VERSION=8.3
FROM php:${PHP_VERSION}-apache

# ================================
# METADATA
# ================================
LABEL maintainer="Moonlit Detailing"
LABEL description="PHP Apache container for Moonlit Detailing application"

# ================================
# INSTALL SYSTEM DEPENDENCIES
# ================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ================================
# INSTALL PHP EXTENSIONS
# ================================
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# ================================
# ENABLE APACHE MODULES
# ================================
RUN a2enmod rewrite headers ssl

# ================================
# CONFIGURE PHP
# ================================
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy custom PHP configuration
COPY docker/php/custom.ini $PHP_INI_DIR/conf.d/custom.ini

# ================================
# SET UP APPLICATION DIRECTORY
# ================================
WORKDIR /var/www

# Copy application files
COPY public/ /var/www/html/
COPY src/ /var/www/src/

# ================================
# SET PERMISSIONS
# ================================
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Create uploads directory with proper permissions
RUN mkdir -p /var/www/html/uploads/receipts \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 775 /var/www/html/uploads

# ================================
# APACHE CONFIGURATION
# ================================
# Set document root to public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ================================
# EXPOSE PORT
# ================================
EXPOSE 80

# ================================
# START APACHE
# ================================
CMD ["apache2-foreground"]

