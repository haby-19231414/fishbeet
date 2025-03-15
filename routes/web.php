<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Pedagang\DashboardController as PedagangDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

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

// Halaman yang bisa diakses tanpa login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/auctions', [HomeController::class, 'auctions'])->name('auctions');
Route::get('/auctions/{auction}', [HomeController::class, 'showAuction'])->name('auctions.show');

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', 'App\Http\Controllers\Admin\UserController');
    Route::resource('fish', 'App\Http\Controllers\Admin\FishController');
    Route::resource('auctions', 'App\Http\Controllers\Admin\AuctionController');
});

// Pedagang routes
Route::prefix('pedagang')->middleware(['auth', 'role:pedagang'])->group(function () {
    Route::get('/dashboard', [PedagangDashboardController::class, 'index'])->name('pedagang.dashboard');
    Route::resource('fish', 'App\Http\Controllers\Pedagang\FishController');
    Route::resource('auctions', 'App\Http\Controllers\Pedagang\AuctionController');
});

// User routes (hanya bisa diakses oleh user yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/auctions/{auction}/bid', [HomeController::class, 'placeBid'])->name('auctions.bid');
    Route::get('/my-bids', [UserDashboardController::class, 'myBids'])->name('user.bids');
    Route::get('/won-auctions', [UserDashboardController::class, 'wonAuctions'])->name('user.won-auctions');
});
