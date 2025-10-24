# Dockerfile
FROM ayahosny/php-base:8.2-with-extensions

WORKDIR /var/www/html

# Copy composer files
COPY ./composer.json ./composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --prefer-dist --no-scripts --no-interaction

# Copy the rest of the app
COPY . .

# Laravel setup
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && chmod -R 777 storage bootstrap/cache \
    && php artisan config:clear || true \
    && php artisan cache:clear || true \
    && php artisan config:cache || true \
    && php artisan storage:link || true

CMD ["php-fpm"]
