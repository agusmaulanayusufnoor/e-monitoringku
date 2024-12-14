dibuat dengan laravel filament versi 3 minimal PHP 8.1 node v.18
instalasi :
git clone https://github.com/agusmaulanayusufnoor/e-monitoringku.git
sesuaikan .env
composer install
npm run dev
jika ada error :
composer autoload-dump
php artisan filament:clear-cached-components
php artisan filament:optimize
php artisan icon:cache

