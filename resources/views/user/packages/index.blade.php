
@extends('master.main')

@section('content')
@php
    $baseurl = 'http://localhost/ngo/public/';
@endphp
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
            <h3 class="fw-bold text-primary mb-2"> Available Packages</h3>
                
                <a href="{{ route('packages.my-purchases') }}" class="btn btn-outline-primary d-flex align-items-center">
                    <iconify-icon icon="solar:bag-4-outline" class="me-2" style="font-size: 1.1rem;"></iconify-icon>
                    My Purchases
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($packages as $package)
            <div class="col-12 col-md-6 col-lg-4 mb-4 mt-3">
                <div class="card shadow-sm package-card h-100" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-header text-center text-white" style="background:
                        @if($package->name == 'Starter') linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
                        @elseif($package->name == 'Professional') linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
                        @else linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
                        @endif
                        border-radius: 0 0 20px 20px;">
                        <h4 class="mb-0">{{ $package->name }}</h4>
                        <div style="font-size: 1.2rem; font-weight: 600;">{{ $package->currency }} {{ number_format($package->price, 2) }} /
                            @if($package->duration_type == 'month') month @elseif($package->duration_type == 'year') year @else {{ $package->duration_type }} @endif
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if($package->image)
                            <div class="text-center mb-3">
                                <img src="{{ $baseurl . $package->image }}" alt="{{ $package->name }}" style="max-width: 200px; max-height: 400px; border-radius: 10px;">
                            </div>
                        @endif
                        <div class="mb-3 text-center">
                            @if($package->icon)
                                <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                                    <img src="{{ $baseurl . $package->icon }}" alt="icon" style="max-width: 24px; max-height: 24px; filter: brightness(0) invert(1);">
                                </div>
                            @endif
                            @if($package->is_featured)
                                <span class="badge bg-warning text-dark fw-semibold px-3 py-2 rounded-pill">
                                    <iconify-icon icon="solar:star-bold" class="me-1"></iconify-icon>
                                    Featured
                                </span>
                            @endif
                        </div>
                        {{-- <div class="mb-2"><strong>Slug:</strong> {{ $package->slug }}</div> --}}
                        <div class="mb-2"><strong>Description:</strong> {{ $package->description }}</div>
                        <div class="mb-2"><strong>Goodies Count:</strong> {{ $package->goodies_count }}</div>
                        <div class="mb-2"><strong>Status:</strong> <span class="badge {{ $package->status ? 'bg-primary' : 'bg-secondary' }}">{{ $package->status ? 'Active' : 'Inactive' }}</span></div>
                        <ul class="list-unstyled mb-0">
                            @php
                                $features = $package->perks ?? [];
                                // Filter out empty features and limit to max 7
                                $validFeatures = array_filter($features, function($feature) {
                                    return !empty($feature) && trim($feature) !== '';
                                });
                                $displayFeatures = array_slice($validFeatures, 0, 7);
                            @endphp
                            @if(count($displayFeatures) > 0)
                                @foreach($displayFeatures as $feature)
                                    <li class="d-flex align-items-center mb-2 feature-item">
                                        <div class="me-3 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px; background-color: #38ef7d; border-radius: 50%; flex-shrink: 0;">
                                            <iconify-icon icon="solar:check-circle-bold" style="color: white; font-size: 0.8rem;"></iconify-icon>
                                        </div>
                                        <span class="flex-grow-1">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center text-muted py-2">
                                    <iconify-icon icon="solar:info-circle-outline" class="me-2"></iconify-icon>
                                    No features listed
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <button type="button" class="btn btn-primary w-100" style="border-radius: 10px;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#paymentModal" 
                                data-package-id="{{ $package->id }}"
                                data-package-name="{{ $package->name }}"
                                data-package-price="{{ $package->price }}"
                                data-package-currency="{{ $package->currency ?? 'INR' }}">
                            Choose {{ $package->name }}
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .package-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .package-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }
    .card-header {
        position: relative;
        overflow: hidden;
    }
    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .package-card:hover .card-header::before {
        left: 100%;
    }
    .feature-item {
        transition: all 0.2s ease;
    }
    .feature-item:hover {
        background-color: rgba(56, 239, 125, 0.1);
        border-radius: 8px;
        padding: 4px 8px;
        margin: 0 -8px;
    }
    @media (max-width: 576px) {
        .package-card {
            margin-bottom: 1.5rem;
        }
        .card-header {
            font-size: 1.1rem;
        }
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
</style>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Complete Your Purchase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm">
                    @csrf
                    <input type="hidden" id="package_id" name="package_id">
                    <input type="hidden" id="purchase_id" name="purchase_id">
                    
                    <div class="mb-3">
                        <label for="package_name" class="form-label">Package</label>
                        <input type="text" class="form-control" id="package_name" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="package_price" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="package_price" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ auth()->user()->email }}" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" id="payButton">
                            <span id="payButtonText">Pay Now</span>
                            <span id="payButtonSpinner" class="spinner-border spinner-border-sm d-none" role="status">
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
    const paymentModal = document.getElementById('paymentModal');
    const paymentForm = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');
    const payButtonText = document.getElementById('payButtonText');
    const payButtonSpinner = document.getElementById('payButtonSpinner');
    
    // Handle modal show event
    paymentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const packageId = button.getAttribute('data-package-id');
        const packageName = button.getAttribute('data-package-name');
        const packagePrice = button.getAttribute('data-package-price');
        const packageCurrency = button.getAttribute('data-package-currency');
        
        // Update modal content
        document.getElementById('package_id').value = packageId;
        document.getElementById('package_name').value = packageName;
        document.getElementById('package_price').value = packageCurrency + ' ' + packagePrice;
    });
    
    // Handle form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const packageId = formData.get('package_id');
        const email = formData.get('email');
        
        // Show loading state
        payButton.disabled = true;
        payButtonText.classList.add('d-none');
        payButtonSpinner.classList.remove('d-none');
        
        // Initiate payment
        fetch('{{ route("packages.initiate-payment") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                package_id: packageId,
                email: email
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
                    name: 'NGO Package Purchase',
                    description: 'Package: ' + document.getElementById('package_name').value,
                    order_id: data.order_id,
                    handler: function (response) {
                        // Handle successful payment
                        handlePaymentSuccess(response, data.purchase_id);
                    },
                    prefill: {
                        email: email,
                        name: '{{ auth()->user()->name }}'
                    },
                    theme: {
                        color: '#007bff'
                    },
                    modal: {
                        ondismiss: function() {
                            // Reset button state
                            resetPayButton();
                        }
                    }
                };
                
                const rzp = new Razorpay(options);
                rzp.open();
            } else {
                alert('Error: ' + data.message);
                resetPayButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            resetPayButton();
        });
    });
    
    function handlePaymentSuccess(response, purchaseId) {
        // Send payment details to backend
        fetch('{{ route("packages.payment-callback") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                razorpay_order_id: response.razorpay_order_id,
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_signature: response.razorpay_signature,
                purchase_id: purchaseId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                const modal = bootstrap.Modal.getInstance(paymentModal);
                modal.hide();
                
                // Redirect to success page
                window.location.href = '{{ url("packages/payment-success") }}/' + data.purchase_id;
            } else {
                alert('Payment verification failed: ' + data.message);
                resetPayButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment verification failed. Please contact support.');
            resetPayButton();
        });
    }
    
    function resetPayButton() {
        payButton.disabled = false;
        payButtonText.classList.remove('d-none');
        payButtonSpinner.classList.add('d-none');
    }
});
</script>
@endsection