<?php

use Illuminate\Support\Facades\Route;
use App\Global\Controllers\AuthController;

// Landing page
Route::get('/', fn () => view('site.home'));

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Sistema (protegido)
Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/main', fn () => view('system.twoclicks.dashboard'))->name('main');
});
