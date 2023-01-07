## About 

Corona virus tracker app built using laravel vue js and tomtom maps.

### Dependencies

* php ^8.0.2
* Composer installed
* NPM
* MYSql

### Installing

Laravel
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
npm run dev
```
Finally
```
php artisan serve 
```
### Points not covered and known Issues 
- Docker 
- Testing 
- App UI 'design is not good'
- App is not responsive
