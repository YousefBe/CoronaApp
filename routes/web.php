<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    \Illuminate\Support\Facades\Log::info(\Illuminate\Support\Str::uuid()->toString());
    return Inertia::render('Welcome', [
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'tomtomKey'=> env('TOMTOM_kEY')
    ]);
});

Route::get('/countries', function () {
    return Inertia::render('Countries' , [
    ]);
});
Route::get('/get-countries',[\App\Http\Controllers\CountryController::class , 'index'])->name('countries');
Route::get('/countries/{country_id}',[\App\Http\Controllers\CountryController::class , 'show'])->name('country');
Route::patch('/countries/{id}',[\App\Http\Controllers\CountryController::class , 'update'])->name('country.update');
Route::post('/countries',[\App\Http\Controllers\CountryController::class , 'store'])->name('country.store');
Route::get('/get-country-data',[\App\Http\Controllers\CountryController::class , 'searchByLongLat'])->name('view.country');
Route::get('/get-latest-updates',[\App\Http\Controllers\CountryController::class , 'getLatestUpdates'])->name('latest.updates');


