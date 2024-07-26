<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Categories Routes
Route::get('category/create',[\App\Http\Controllers\CategoryController::class,'create'])->name('category.create');
Route::post('category/store',[\App\Http\Controllers\CategoryController::class,'store'])->name('category.store');

// Products Routes
Route::get('/products',[\App\Http\Controllers\ProductController::class,'index'])->name('products.index')->middleware(['auth', 'verified']);
Route::get('/products/create',[\App\Http\Controllers\ProductController::class,'create'])->name('products.create');
Route::post('/products/store',[\App\Http\Controllers\ProductController::class,'store'])->name('products.store');
Route::get('/products/{product}',[\App\Http\Controllers\ProductController::class,'show'])->name('products.show');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');

// Orders Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});

require __DIR__.'/auth.php';
