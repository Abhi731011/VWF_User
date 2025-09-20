<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\SupportFeedbackController;
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\ProjectController;
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

// Test route for Razorpay integration (remove in production)
Route::get('/test-razorpay', function () {
    try {
        $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        return response()->json([
            'success' => true,
            'message' => 'Razorpay API initialized successfully!',
            'key_id' => env('RAZORPAY_KEY_ID')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error initializing Razorpay: ' . $e->getMessage()
        ], 500);
    }
});

// Test route for projects data (remove in production)
Route::get('/test-projects', function () {
    try {
        $projects = \App\Models\Project::where('status', 'published')
                          ->where('visibility', true)
                          ->with('category')
                          ->orderBy('created_at', 'desc')
                          ->limit(1)
                          ->get();
        
        if ($projects->count() > 0) {
            $project = $projects->first();
            return response()->json([
                'success' => true,
                'project_data' => [
                    'title' => $project->title,
                    'title_type' => gettype($project->title),
                    'slug' => $project->slug,
                    'slug_type' => gettype($project->slug),
                    'images' => $project->images,
                    'images_type' => gettype($project->images),
                    'category' => $project->category,
                    'category_type' => gettype($project->category),
                    'location' => $project->location,
                    'location_type' => gettype($project->location),
                    'short_description' => $project->short_description,
                    'short_description_type' => gettype($project->short_description),
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No projects found'
            ]);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
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
        Route::get('/my-purchases', [PackageController::class, 'myPurchases'])->name('my-purchases');
        Route::get('/featured', [PackageController::class, 'featured'])->name('featured');
        Route::get('/compare', [PackageController::class, 'compare'])->name('compare');
        Route::get('/data', [PackageController::class, 'getPackagesData'])->name('data');
        Route::get('/{slug}', [PackageController::class, 'show'])->name('show');
        Route::get('/{slug}/purchase', [PackageController::class, 'purchase'])->name('purchase');
        
        // Payment routes
        Route::post('/initiate-payment', [PackageController::class, 'initiatePayment'])->name('initiate-payment');
        Route::post('/payment-callback', [PackageController::class, 'handlePaymentCallback'])->name('payment-callback');
        Route::get('/payment-success/{purchaseId}', [PackageController::class, 'paymentSuccess'])->name('payment-success');
    });
    
    // Support & Feedback Routes
    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', [SupportFeedbackController::class, 'index'])->name('index');
        Route::post('/', [SupportFeedbackController::class, 'store'])->name('store');
        Route::get('/{supportFeedback}', [SupportFeedbackController::class, 'show'])->name('show');
    });
    
    // Projects Routes
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::get('/my-donations', [ProjectController::class, 'myDonations'])->name('my-donations');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
        
        // Donation routes
        Route::post('/initiate-donation', [ProjectController::class, 'initiateDonation'])->name('initiate-donation');
        Route::post('/donation-callback', [ProjectController::class, 'handleDonationCallback'])->name('donation-callback');
        Route::get('/donation-success/{donationId}', [ProjectController::class, 'donationSuccess'])->name('donation-success');
    });
    
    // Certificate Request Routes
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/', [CertificateRequestController::class, 'index'])->name('index');
        Route::get('/create', [CertificateRequestController::class, 'create'])->name('create');
        Route::post('/', [CertificateRequestController::class, 'store'])->name('store');
        Route::get('/{certificateRequest}', [CertificateRequestController::class, 'show'])->name('show');
    });
});

require __DIR__.'/auth.php';
