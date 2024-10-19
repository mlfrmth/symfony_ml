FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install zip

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_23.x | bash - && \
    apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Set permissions for var directory
RUN mkdir /var/www/var
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/var

# Install PHP extensions
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install pdo pdo_mysql

COPY config/docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
