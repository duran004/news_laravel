# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
#add name
RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

# Set composer to run as non-root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy existing application directory contents
COPY . .

RUN chmod -R 777 /var/www/html/storage
#if lock file exists, remove it
RUN rm -f /var/www/html/composer.lock 
RUN rm -f /var/www/html/bootstrap/cache/*.php
#remove vendor folder
RUN rm -rf /var/www/html/vendor
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer




# Install application dependencies
RUN composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist


# Regenerate autoloader files (optional, but recommended)
# RUN composer dump-autoload

# Expose port and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]