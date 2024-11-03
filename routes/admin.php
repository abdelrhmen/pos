<?php

use App\Http\Controllers\dashboard\DashBoardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ClientController;
use App\Http\Controllers\dashboard\ProductController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::prefix('admin')->name('dashboard.')->middleware(['auth'])->group(function() {

            Route::get('index',[DashBoardController::class,'index'])->name('index');


            //Route of categories
            Route::resource('categories', CategoryController::class)->except('show');

            //Route of productes
            Route::resource('products', ProductController::class)->except('show');

            //Route of users
            Route::resource('user', UserController::class)->except('show');


            //Route of client
            Route::resource('clients', ClientController::class)->except('show');
        });

    });





