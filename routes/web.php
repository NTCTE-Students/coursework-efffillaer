<?php

use App\Http\Controllers\ActionsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewsController;

Route::get('/', [ViewsController::class, 'index'])->name('index');
Route::get('/register', [ViewsController::class, 'register'])->name('register')->middleware('guest');
Route::get('/login', [ViewsController::class, 'login'])->name('login')->middleware('guest');
Route::post('/register', [ActionsController::class, 'register']);
Route::post('/login', [ActionsController::class, 'login']);
Route::get('/logout', [ActionsController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/profile', [ViewsController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/tour/buy/{tour}', [ActionsController::class, 'tour_buy'])->name('tour.buy')->middleware('auth');
Route::post('/booking/review/{booking}', [ActionsController::class, 'booking_review'])->name('booking.review')->middleware('auth');
Route::put('/profile/update', [ActionsController::class, 'profile_update'])->name('profile.update')->middleware('auth');