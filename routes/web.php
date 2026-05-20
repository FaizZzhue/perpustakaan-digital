<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');
Route::resource('books', BookController::class);