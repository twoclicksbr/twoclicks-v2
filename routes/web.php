<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('site.home'));
Route::get('/painel', fn () => view('system.twoclicks.dashboard'))->name('dashboard');
Route::get('/login', fn () => view('system.twoclicks.login'))->name('login');
