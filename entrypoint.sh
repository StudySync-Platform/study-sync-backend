#!/bin/bash

# Delete .env to force Laravel to use environment variables
rm -f /var/www/html/.env

cd /var/www/html

echo "🌟 Starting Laravel setup..."
composer install --no-interaction --prefer-dist --optimize-autoloader

 php artisan migrate --force --no-interaction
# php artisan db:seed
php artisan storage:link
php artisan optimize:clear

# Clear config cache to make sure correct DB_HOST is used
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Permissions
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 777 storage bootstrap/cache

# Start Nginx and PHP-FPM
nginx -g "daemon off;" &

exec php-fpm  # Keep PHP-FPM in foreground
