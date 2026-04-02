FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

# ✅ THIS LINE FIXES YOUR ISSUE
RUN sed -i 's|127.0.0.1:9000|9000|' /usr/local/etc/php-fpm.d/www.conf

RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]