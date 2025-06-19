<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminReservationController;

// Home page menggunakan HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

// Menu routes
Route::resource('menu', MenuController::class);
Route::get('/menu/show', [MenuController::class, 'show'])->name('menu.showmenu');


// Tables routes
Route::resource('tables', TableController::class);

// Auth routes
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Reservations
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/reservations/history', [ReservationController::class, 'showOrderDetail'])->name('reservations.history');
Route::post('/reservations/{id}/upload-proof', [ReservationController::class, 'uploadProof'])->name('reservations.uploadProof');

use App\Http\Controllers\PasswordController;

Route::get('/admin/reservations/confirmation', [AdminReservationController::class, 'index'])->name('admin.reservations.index');
Route::post('/admin/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->name('admin.reservations.confirm');
Route::post('/admin/reservations/{reservation}/finish', [AdminReservationController::class, 'finish'])->name('admin.reservations.finish');
Route::post('/admin/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('admin.reservations.cancel');

Route::get('/admin', function () {
    return view('adminpage');
})->name('admin.dashboard')->middleware('auth');


Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('/admin', function () {
        return view('adminpage');
    })->name('admin.dashboard');

    // Tables (akses dikendalikan di controller)
    Route::resource('tables', TableController::class);

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/history', [ReservationController::class, 'showOrderDetail'])->name('reservations.history');
});


Route::get('/password/reset', [PasswordController::class, 'showResetForm'])->name('password.form')->middleware('auth');
Route::post('/password/reset', [PasswordController::class, 'updatePassword'])->name('password.update')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/daily', [OrderController::class, 'dailyReport'])->name('orders.daily');
    Route::get('/orders/monthly', [OrderController::class, 'monthlyReport'])->name('orders.monthly');
    Route::get('/orders/yearly', [OrderController::class, 'yearlyReport'])->name('orders.yearly');
});
