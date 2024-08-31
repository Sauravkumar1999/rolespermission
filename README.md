composer install
php artisan migrate --seed || php artisan migrate:refresh --seed
