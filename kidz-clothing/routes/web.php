<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CheckoutController;

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

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Us
Route::get('/about-us', function () {
    return view('Aboutus', [
        'pageTitle'       => 'About Us | Kidz Wear',
        'metaDescription' => 'Learn about Kidz Wear — your trusted kids clothing brand in Pakistan.',
    ]);
})->name('about');

// FAQs
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');

// Contact Us
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Categories List
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog');

// Blog Post Detail
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.post');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');

// Admin Login Routes (No Auth Required)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// Admin Panel (Auth Required)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/home', [AdminController::class, 'home'])->name('home');
    Route::post('/home/update-banner', [AdminController::class, 'updateBanner'])->name('home.updateBanner');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    
    // Category Management Routes
    Route::get('/category', [AdminController::class, 'categoryList'])->name('category');
    Route::get('/category/add', [AdminController::class, 'addCategory'])->name('category.add');
    Route::post('/category/store', [AdminController::class, 'storeCategory'])->name('category.store');
    Route::get('/category/edit/{id}', [AdminController::class, 'editCategory'])->name('category.edit');
    Route::post('/category/update/{id}', [AdminController::class, 'updateCategory'])->name('category.update');
    Route::post('/category/{id}/delete', [AdminController::class, 'deleteCategory'])->name('category.delete');
    
    // Product Management Routes
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::get('/products/add', [AdminController::class, 'addProduct'])->name('products.add');
    Route::post('/products/store', [AdminController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::post('/products/update/{id}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::post('/products/{id}/delete', [AdminController::class, 'deleteProduct'])->name('products.delete');
    
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('blogs');
    Route::get('/blogs/add', [AdminBlogController::class, 'create'])->name('blogs.add');
    Route::post('/blogs/store', [AdminBlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('blogs.edit');
    Route::get('/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('blogs.update');
    Route::post('/blogs/{id}/delete', [AdminBlogController::class, 'destroy'])->name('blogs.delete');
    
    // Order Management Routes
    Route::get('/orders', [AdminController::class, 'orderList'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'viewOrder'])->name('orders.view');
    Route::post('/orders/{id}/delete', [AdminController::class, 'deleteOrder'])->name('orders.delete');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::get('/password', [AdminController::class, 'password'])->name('password');
});

// Category Slug Route (MUST BE LAST - Catch-all route)
Route::get('/{slug}', [CategoryController::class, 'show'])->name('categories.show');


