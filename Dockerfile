FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]