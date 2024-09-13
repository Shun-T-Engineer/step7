<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/products/list', [App\Http\Controllers\ProductController::class, 'showList'])->name('product.list');
    Route::get('/product/regist', [App\Http\Controllers\ProductController::class, 'showProductRegistForm'])->name('product.regist.form');
    Route::post('/product/regist', [App\Http\Controllers\ProductController::class, 'productSubmit'])->name('product.submit');
    Route::get('/product/show/{id}', [App\Http\Controllers\ProductController::class, 'productShow'])->name('product.show');
    Route::get('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'showProductUpdate'])->name('product.update');
    Route::put('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'productUpdateSubmit'])->name('product.update.submit');
    Route::post('/product/destroy/{id}', [App\Http\Controllers\ProductController::class, 'productDestroy'])->name('product.destroy');
});
