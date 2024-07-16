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
RUN rm -f /var/www/html/bootstrap/cache/*
#remove vendor folder
RUN rm -rf /var/www/html/vendor
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install application dependencies
RUN composer install 
# laravel publish files
# RUN php artisan vendor:publish --force
# Run artisan commands
# RUN php artisan key:generate
# RUN php artisan config:cache
# RUN php artisan route:cache
# RUN php artisan view:cache
# # Run database migrations
# RUN php artisan migrate --force
# # Run database seeders
# RUN php artisan db:seed --force
# # storage link
# RUN php artisan storage:link

# Regenerate autoloader files (optional, but recommended)
# RUN composer dump-autoload

# Expose port and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]