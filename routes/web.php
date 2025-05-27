<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ReviewController;
use App\Models\Product;
use App\Models\Review;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/export-orders', function () {
    return Excel::download(new OrdersExport, 'orders.xlsx');
});

Route::get('/', function () {
    $products = Product::with('reviews')->get()->sortByDesc(function ($product) {
        return $product->reviews->avg('rating');
    });
    $reviews = Review::where('rating', '>=', 4)->inRandomOrder()->take(3)->get();
    return view('welcome', compact('products', 'reviews'));
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth'])->get('/dashboard', [FavoriteController::class, 'lk'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/favorites', [FavoriteController::class, 'favoriteProducts'])->name('favorites.index');
Route::post('/favorites/{product}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review');
Route::middleware('auth')->group(function () {
    Route::get('reviews/{reviewId}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{reviewId}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('reviews/{reviewId}', [ReviewController::class, 'destroy'])->name('review.destroy');
});
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/search', [CatalogController::class, 'search'])->name('products.search');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::put('/admin/products/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products');
});

Route::get('/admin', [AdminController::class, 'index'])
    ->name('admin.index')
    ->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/admin/users/{user}/toggle-ban', [UserController::class, 'toggleBan'])->name('users.toggleBan');
    Route::post('/admin/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.changeRole');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index'); // Список категорий
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create'); // Форма создания
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store'); // Создание
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit'); // Форма редактирования
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); // Обновление
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); // Удаление
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Список заказов
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus'); // Изменение статуса
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Удаление заказа
});
Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

Route::middleware('admin')->group(function () {
    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/admin/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/admin/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/admin/reviews/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
});

Route::get('/admin/reviews/export', [ReviewController::class, 'export'])->name('reviews.export');


Route::get('/sizes/{category}', [SizeController::class, 'getSizes']);
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
});
Route::post('/cart/update-item', [CartController::class, 'updateItem'])->name('cart.updateItem');


Route::post('/order', [CartController::class, 'createOrder'])->name('order.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/favorites/toggle/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
});

// Маршруты для отзывов
Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__ . '/auth.php';
