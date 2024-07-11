<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Auth route start*/
Route::group(['prefix' => 'v1/auth'], function (){

    /*login route start*/
    Route::post('/login', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\V1\Auth\RegisterController::class, 'register']);
    /*login route end*/

    Route::group(['middleware' => 'jwtAuth'], function (){

        /*logout route start*/
        Route::post('/logout', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'logout']);
        /*logout route end*/

        /*check token route start*/
        Route::post('/checkToken', [\App\Http\Controllers\Api\V1\Auth\LoginController::class, 'checkToken']);
        /*check token route end*/
    });
});
/* Auth route end*/

/*Admin route start*/
Route::group(['prefix' => 'v1/admin', 'middleware' => 'jwtAuth'], function (){

    /*products route start*/
    Route::get('/products', [\App\Http\Controllers\Api\V1\Admin\ProductController::class, 'index']);
    Route::post('/products', [\App\Http\Controllers\Api\V1\Admin\ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}', [\App\Http\Controllers\Api\V1\Admin\ProductController::class, 'show']);
    Route::put('/products/{id}', [\App\Http\Controllers\Api\V1\Admin\ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\Api\V1\Admin\ProductController::class, 'destroy']);
    /*products route end*/


    /*customer route start*/
    Route::get('/customer', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'index']);
    Route::post('/customer', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'show']);
    Route::put('/customer/{id}', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{id}', [\App\Http\Controllers\Api\V1\Admin\CustomerController::class, 'destroy']);
    /*customer route start*/


    /*order route start*/
    Route::get('/order', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'index']);
    Route::post('/order', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'show']);
    Route::put('/order/{id}', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}', [\App\Http\Controllers\Api\V1\Admin\OrderController::class, 'destroy']);
    /*order route end*/
});
/*Admin route end*/
