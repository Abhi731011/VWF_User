<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PackageController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/profile/view', [DashboardController::class, 'profile'])
    ->middleware(['auth', 'verified'])
    ->name('profile.view');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('password.update');
    //packages
Route::prefix('packages')->name('packages.')->group(function () {
    Route::get('/', [PackageController::class, 'index'])->name('index');
    Route::get('/featured', [PackageController::class, 'featured'])->name('featured');
    Route::get('/compare', [PackageController::class, 'compare'])->name('compare');
    Route::get('/data', [PackageController::class, 'getPackagesData'])->name('data');
    Route::get('/{slug}', [PackageController::class, 'show'])->name('show');
    Route::get('/{slug}/purchase', [PackageController::class, 'purchase'])->name('purchase');
});});

require __DIR__.'/auth.php';
