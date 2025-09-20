@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="projects-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Available Projects</h3>
                <p class="text-secondary-light mb-0">Discover our ongoing projects and contribute to meaningful causes in your community.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="projects-info-card">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2">
                        <iconify-icon icon="solar:folder-outline" class="text-primary" style="font-size: 1.5rem;"></iconify-icon>
                        <span class="fw-semibold text-primary">Active Projects</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <iconify-icon icon="solar:check-circle-outline" class="me-2"></iconify-icon>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <iconify-icon icon="solar:danger-circle-outline" class="me-2"></iconify-icon>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Projects Grid -->
    @if($projects->count() > 0)
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-4 mb-24">
            @foreach($projects as $project)
                @php
                    // Define all variables at the top to avoid undefined variable errors
                    $title = is_array($project->title) ? $project->title['text'] ?? $project->title['name'] ?? '' : $project->title;
                    $slug = is_array($project->slug) ? $project->slug['value'] ?? $project->slug['name'] ?? '' : $project->slug;
                    $description = is_array($project->short_description) ? $project->short_description['text'] ?? '' : $project->short_description;
                    $categoryName = is_object($project->category) ? $project->category->name : (is_array($project->category) ? $project->category['name'] ?? '' : $project->category);
                    $location = is_array($project->location) ? $project->location['name'] ?? $project->location['address'] ?? '' : $project->location;
                    
                    // Debug: Check data types
                    if (config('app.debug')) {
                        \Log::info('Project data types:', [
                            'title_type' => gettype($project->title),
                            'slug_type' => gettype($project->slug),
                            'images_type' => gettype($project->images),
                            'category_type' => gettype($project->category),
                            'location_type' => gettype($project->location),
                            'short_description_type' => gettype($project->short_description),
                        ]);
                    }
                @endphp
                <div class="col">
                    <div class="card shadow-sm border-0 h-100 project-card">
                        <div class="project-image-container position-relative">
                            @if($project->images && count($project->images) > 0)
                                @php
                                    $firstImage = is_array($project->images[0]) ? $project->images[0]['url'] ?? $project->images[0]['path'] ?? '' : $project->images[0];
                                @endphp
                                @if($firstImage)
                                    <img src="{{ $baseurl }}/{{ $firstImage }}" class="card-img-top project-banner" alt="{{ $title }}">
                                @else
                                    <div class="card-img-top project-banner-placeholder d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:folder-outline" style="font-size: 3rem; color: #6c757d;"></iconify-icon>
                                    </div>
                                @endif
                            @else
                                <div class="card-img-top project-banner-placeholder d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:folder-outline" style="font-size: 3rem; color: #6c757d;"></iconify-icon>
                                </div>
                            @endif
                            <!-- Donate Now Button -->
                            <div class="donate-button-overlay">
                                <button class="btn btn-success btn-sm donate-now-btn d-inline-flex align-items-center"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#donationModal" 
                                        data-project-id="{{ $project->id }}"
                                        data-project-name="{{ $title }}"
                                        data-project-slug="{{ $slug }}">
                                    <iconify-icon icon="solar:hand-money-outline" class="me-1"></iconify-icon>
                                    Donate Now
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body p-24">
                            <!-- Category Badge -->
                            @if($project->category && $categoryName)
                                <span class="badge bg-primary-subtle text-primary mb-16">{{ $categoryName }}</span>
                            @endif
                            
                            <!-- Project Title -->
                            <h5 class="card-title fw-bold text-dark mb-12">{{ $title }}</h5>
                            
                            <!-- Short Description -->
                            <p class="card-text text-secondary-light mb-16">{{ Str::limit($description, 120) }}</p>
                            
                            <!-- Project Details -->
                            <div class="project-details mb-16">
                                @if($project->target_amount)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:dollar-minimalistic-outline" class="text-success me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Target: ₹{{ number_format($project->target_amount) }}</span>
                                    </div>
                                @endif
                                
                                @if($project->min_donation)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:hand-money-outline" class="text-info me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Min Donation: ₹{{ number_format($project->min_donation) }}</span>
                                    </div>
                                @endif
                                
                                @if($project->end_date)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:calendar-outline" class="text-warning me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Ends: {{ $project->end_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($project->location && $location)
                                    <div class="d-flex align-items-center">
                                        <iconify-icon icon="solar:map-point-outline" class="text-danger me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">{{ $location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 p-24 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('projects.show', $slug) }}" class="btn btn-primary flex-fill d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:eye-outline" class="me-2"></iconify-icon>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($projects->hasPages())
            <div class="d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        @endif
    @else
        <!-- No Projects Found -->
        <div class="text-center py-5">
            <iconify-icon icon="solar:folder-outline" style="font-size: 4rem; color: #6c757d;"></iconify-icon>
            <h5 class="mt-3">No Projects Available</h5>
            <p class="text-muted">There are currently no active projects to display.</p>
        </div>
    @endif
</div>

<style>
.projects-info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 16px 20px;
    border-radius: 12px;
    border: 1px solid #dee2e6;
}

.project-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.project-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.project-banner {
    height: 200px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}

.project-banner-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px 12px 0 0;
}

.project-image-container {
    overflow: hidden;
}

.donate-button-overlay {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 10;
}

.donate-now-btn {
    background: rgba(9, 58, 43, 0.9) !important;
    border: 1px solid rgba(9, 58, 43, 0.9) !important;
    color: white !important;
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    backdrop-filter: blur(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.donate-now-btn:hover {
    background: rgba(9, 58, 43, 1) !important;
    border-color: rgba(9, 58, 43, 1) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.project-details {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 4px solid #0d6efd;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.card-body {
    padding: 1.5rem !important;
}

.card-footer {
    padding: 1.5rem !important;
    padding-top: 0 !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.alert {
    margin-bottom: 1.5rem !important;
}
</style>

<!-- Donation Modal -->
<div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="donationModalLabel">Make a Donation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="donationForm">
                    @csrf
                    <input type="hidden" id="project_id" name="project_id">
                    <input type="hidden" id="donation_id" name="donation_id">
                    
                    <div class="mb-3">
                        <label for="project_name" class="form-label">Project</label>
                        <input type="text" class="form-control" id="project_name" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="amount" class="form-label">Donation Amount (₹)</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="donor_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="donor_name" name="donor_name" 
                               value="{{ auth()->user()->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="donor_email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="donor_email" name="donor_email" 
                               value="{{ auth()->user()->email }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="donor_phone" class="form-label">Phone Number (Optional)</label>
                        <input type="tel" class="form-control" id="donor_phone" name="donor_phone">
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message (Optional)</label>
                        <textarea class="form-control" id="message" name="message" rows="3" 
                                  placeholder="Leave a message for the project organizers..."></textarea>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous">
                        <label class="form-check-label" for="is_anonymous">
                            Make this donation anonymous
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" id="donateButton">
                            <span id="donateButtonText">Donate Now</span>
                            <span id="donateButtonSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const donationModal = document.getElementById('donationModal');
    const donationForm = document.getElementById('donationForm');
    const donateButton = document.getElementById('donateButton');
    const donateButtonText = document.getElementById('donateButtonText');
    const donateButtonSpinner = document.getElementById('donateButtonSpinner');
    
    // Handle modal show event
    donationModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const projectId = button.getAttribute('data-project-id');
        const projectName = button.getAttribute('data-project-name');
        
        // Update modal content
        document.getElementById('project_id').value = projectId;
        document.getElementById('project_name').value = projectName;
    });
    
    // Handle form submission
    donationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const projectId = formData.get('project_id');
        const amount = formData.get('amount');
        const donorName = formData.get('donor_name');
        const donorEmail = formData.get('donor_email');
        const donorPhone = formData.get('donor_phone');
        const message = formData.get('message');
        const isAnonymous = formData.get('is_anonymous') ? true : false;
        
        // Show loading state
        donateButton.disabled = true;
        donateButtonText.classList.add('d-none');
        donateButtonSpinner.classList.remove('d-none');
        
        // Initiate donation
        fetch('{{ route("projects.initiate-donation") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                project_id: projectId,
                amount: amount,
                donor_name: donorName,
                donor_email: donorEmail,
                donor_phone: donorPhone,
                message: message,
                is_anonymous: isAnonymous
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Open Razorpay checkout
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: data.currency,
                    name: 'NGO Project Donation',
                    description: 'Donation for: ' + document.getElementById('project_name').value,
                    order_id: data.order_id,
                    handler: function (response) {
                        // Handle successful payment
                        handleDonationSuccess(response, data.donation_id);
                    },
                    prefill: {
                        email: donorEmail,
                        name: donorName
                    },
                    theme: {
                        color: '#28a745'
                    },
                    modal: {
                        ondismiss: function() {
                            // Reset button state
                            resetDonateButton();
                        }
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                alert('Error: ' + data.message);
                resetDonateButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            resetDonateButton();
        });
    });
    
    function handleDonationSuccess(response, donationId) {
        // Send payment details to backend
        fetch('{{ route("projects.donation-callback") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                razorpay_order_id: response.razorpay_order_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature,
                donation_id: donationId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(donationModal);
                modal.hide();
                
                // Redirect to success page
                window.location.href = '{{ url("projects/donation-success") }}/' + data.donation_id;
            } else {
                alert('Payment verification failed: ' + data.message);
                resetDonateButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment verification failed. Please contact support.');
            resetDonateButton();
        });
    }
    
    function resetDonateButton() {
        donateButton.disabled = false;
        donateButtonText.classList.remove('d-none');
        donateButtonSpinner.classList.add('d-none');
    }
});
</script>
@endsection
