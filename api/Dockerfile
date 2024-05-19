# Use the official PHP image with PHP 8.1 and FPM
FROM php:8.3-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-install sockets

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy the composer.json file to the container
COPY composer.json /var/www/html

# Copy the composer.lock file to the container
COPY composer.lock /var/www/html

# Install PHP dependencies
RUN composer update --no-scripts --no-autoloader

RUN composer install --no-scripts --no-autoloader

# Copy the application files to the container
COPY  . /var/www/html

# Run Composer dump-autoload to optimize autoloader
RUN composer dump-autoload --optimize

# Expose port 8000 to communicate with Nginx or other web server
EXPOSE 8000

# Start PHP-FPM server
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
