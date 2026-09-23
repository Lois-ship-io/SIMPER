<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('books', \App\Http\Controllers\BookController::class);
    Route::resource('members', \App\Http\Controllers\MemberController::class);
    Route::resource('visitors', \App\Http\Controllers\VisitorController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('publishers', \App\Http\Controllers\PublisherController::class);
    Route::resource('racks', \App\Http\Controllers\RackController::class);
    Route::resource('borrowings', \App\Http\Controllers\BorrowingController::class);
    Route::resource('returns', \App\Http\Controllers\ReturnBookController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('can:users.view');
    
    // Reports
    Route::get('reports/borrowings', [\App\Http\Controllers\ReportController::class, 'borrowings'])->name('reports.borrowings');
    Route::get('reports/returns', [\App\Http\Controllers\ReportController::class, 'returns'])->name('reports.returns');
});

require __DIR__.'/auth.php';
