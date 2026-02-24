<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
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

Route::get('/', [ProductController::class, 'index']);
Route::get('/item/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware(['check.profile'])->group(function () {
        Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.show');
        Route::post('/item/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/item/{product}/favorite', [FavoriteController::class, 'store'])->name('favorite.store');
        Route::delete('/item/{product}/favorite', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
        Route::get('/purchase/{product}', [PurchaseController::class, 'show'])->name('purchase.show');
        Route::get('/purchase/address/{product}', [AddressController::class, 'edit'])->name('address.edit');
        Route::post('/purchase/address/{product}', [AddressController::class, 'update'])->name('address.update');
        Route::post('/purchase/{product}', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::get('/sell', [ProductController::class, 'create'])->name('product.create');
        Route::post('/sell', [ProductController::class, 'store'])->name('product.store');
    });
});
