<?php

use App\Http\Controllers\Api\V1\Admin\CustomerController;
use App\Http\Controllers\Api\V1\Admin\OrderController;
use App\Http\Controllers\Api\V1\Admin\ProductController;
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
Route::group(['prefix' => 'v1/admin' , 'middleware' => 'jwtAuth'], function (){

    /*products route start*/
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    /*products route end*/


    /*customer route start*/
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/{id}', [CustomerController::class, 'show']);
    Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);

    Route::post('customer/import', [CustomerController::class, 'import'])->name('customer.import');
    Route::get('customer-download', [CustomerController::class, 'download'])->name('customer.export');
    /*customer route start*/


    /*order route start*/
    Route::get('/order', [OrderController::class, 'index']);
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::put('/order/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/{id}', [OrderController::class, 'destroy']);
    /*order route end*/
});
/*Admin route end*/
