<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


route::middleware('isLogin')->group(function () {
    route::get('/product', [ProductController::class, 'index'])->name('pageProduct');
    route::post('/product/add', [ProductController::class, 'store'])->name('createProduct');
    route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
    route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('editProduct');
    route::put('/product/update/{id}', [ProductController::class, 'update'])->name('updateProduct');
    route::get('/product/stock/{id}', [ProductController::class, 'pageStock'])->name('stockProduct');
    route::post('/product/add/stock/{id}', [ProductController::class, 'updateStock'])->name('updateStock');

    route::get('/user', [AuthController::class, 'index'])->name('pageUser');
    route::post('/user/add', [AuthController::class, 'store'])->name('createUser');
    route::put('/user/edit/{id}', [AuthController::class, 'update'])->name('updateUser');
    route::delete('/user/delete/{id}', [AuthController::class, 'destroy'])->name('deleteUser');

    route::get('/purchase', [PurchaseController::class, 'index'])->name('pagePurchase');

    route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});


route::middleware('isGuest')->group(function () {
    route::get('/login', [AuthController::class, 'pageLogin'])->name('login');
    route::post('/login', [AuthController::class, 'postLogin'])->name('authLogin');
});
