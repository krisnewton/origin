composer require laravel/ui:^2.4
php artisan ui:auth bootstrap
composer require harishariyanto/origin:dev-master
php artisan vendor:publish --force
composer dump-autoload
php artisan migrate:fresh --seed