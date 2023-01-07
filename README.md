## About 

Corona virus tracker app built using laravel vue js and tomtom maps.

### Dependencies

* php ^8.0.2
* Composer installed
* NPM
* MYSql

### Installing

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan queue:work
```
NPM
```
npm i 
npm run build
```
Finally
```
php artisan serve 
```
