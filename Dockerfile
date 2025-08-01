# Use official PHP with Apache
FROM php:8.2-apache

# Enable mod_rewrite (needed for clean URLs)
RUN a2enmod rewrite

# ✅ Install PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pgsql

# Copy your app code
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80
