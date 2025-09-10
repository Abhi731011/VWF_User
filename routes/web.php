<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PackageController;
use App\Services\EmailService;
use App\Models\User;


Route::get('/', function () {
    return redirect()->route('login');
});

// Test route for email functionality (remove in production)
Route::get('/test-email', function () {
    try {
        // Create a test user
        $testUser = new User([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'created_at' => now(),
        ]);
        
        // Send test emails
        EmailService::sendRegistrationNotifications($testUser);
        
        return response()->json([
            'success' => true,
            'message' => 'Test emails sent successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error sending emails: ' . $e->getMessage()
        ], 500);
    }
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
    
    // Event Registration Routes
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [EventRegistrationController::class, 'index'])->name('index');
        Route::get('/my-registrations', [EventRegistrationController::class, 'myRegistrations'])->name('my-registrations');
        Route::get('/{event}/register', [EventRegistrationController::class, 'create'])->name('register');
        Route::post('/{event}/register', [EventRegistrationController::class, 'store'])->name('store');
        Route::get('/registration/{eventRegistration}', [EventRegistrationController::class, 'show'])->name('registration.show');
        Route::patch('/registration/{eventRegistration}/cancel', [EventRegistrationController::class, 'cancel'])->name('registration.cancel');
    });
    
    //packages
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::get('/featured', [PackageController::class, 'featured'])->name('featured');
        Route::get('/compare', [PackageController::class, 'compare'])->name('compare');
        Route::get('/data', [PackageController::class, 'getPackagesData'])->name('data');
        Route::get('/{slug}', [PackageController::class, 'show'])->name('show');
        Route::get('/{slug}/purchase', [PackageController::class, 'purchase'])->name('purchase');
    });
});

require __DIR__.'/auth.php';
