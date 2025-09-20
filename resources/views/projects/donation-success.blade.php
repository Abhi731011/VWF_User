@extends('master.main')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="ri-heart-fill me-2"></i>
                        Donation Successful!
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="ri-heart-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h5 class="text-success mb-3">Thank you for your generous donation!</h5>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Donation Details</h6>
                                    <p class="card-text">
                                        <strong>Project:</strong> {{ $donation->project_name }}<br>
                                        <strong>Amount:</strong> {{ $donation->currency }} {{ number_format($donation->amount, 2) }}<br>
                                        <strong>Donor:</strong> {{ $donation->is_anonymous ? 'Anonymous' : $donation->donor_name }}<br>
                                        <strong>Date:</strong> {{ $donation->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Payment Details</h6>
                                    <p class="card-text">
                                        <strong>Payment ID:</strong> {{ $donation->razorpay_payment_id }}<br>
                                        <strong>Order ID:</strong> {{ $donation->razorpay_order_id }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-success">{{ ucfirst($donation->status) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($donation->message)
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Your Message:</h6>
                            <p class="mb-0">{{ $donation->message }}</p>
                        </div>
                    @endif
                    
                    <div class="alert alert-success">
                        <i class="ri-information-line me-2"></i>
                        Your donation has been successfully processed and will help make a difference in the community. Thank you for your support!
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('projects.index') }}" class="btn btn-primary">
                            <i class="ri-arrow-left-line me-2"></i>
                            Back to Projects
                        </a>
                        <a href="{{ route('projects.my-donations') }}" class="btn btn-outline-primary">
                            <i class="ri-heart-line me-2"></i>
                            View My Donations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0;
    }
</style>
@endsection
