# Use an official PHP image with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy your PHP app into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Optional: install PHP extensions (e.g., mysqli, pdo)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Permissions fix (if needed)
RUN chown -R www-data:www-data /var/www/html

# Expose Apache port
EXPOSE 80
