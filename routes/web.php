<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\MemberDashboardController;

// Public Catalog Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/catalog/books/{book}', [LandingController::class, 'show'])->name('public.books.show');

// Guest-only Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Member-only Routes
    Route::middleware(['role:member'])->group(function () {
        Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    });

    // Admin-only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [BookController::class, 'dashboard'])->name('dashboard');
        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);

        Route::post('borrows/{borrow}/return', [BorrowController::class, 'returnBook'])->name('borrows.return');
        Route::resource('borrows', BorrowController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

        Route::post('fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');
        Route::resource('fines', FineController::class)->only(['index', 'show']);

        // Ebooks modification routes (Admin only)
        Route::resource('ebooks', EbookController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    });

    // Shared Ebook viewing routes (Admin & Member)
    Route::resource('ebooks', EbookController::class)->only(['index', 'show']);
    Route::get('ebooks/{ebook}/read', [EbookController::class, 'read'])->name('ebooks.read');
    Route::get('ebooks/{ebook}/download', [EbookController::class, 'download'])->name('ebooks.download');
});