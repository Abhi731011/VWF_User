@extends('master.main')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">
                        <i class="ri-checkbox-circle-fill me-2"></i>
                        Payment Successful!
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="ri-checkbox-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h5 class="text-success mb-3">Thank you for your purchase!</h5>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Package Details</h6>
                                    <p class="card-text">
                                        <strong>Package:</strong> {{ $purchase->package_name }}<br>
                                        <strong>Amount:</strong> {{ $purchase->currency }} {{ number_format($purchase->amount, 2) }}<br>
                                        <strong>Purchase Date:</strong> {{ $purchase->created_at->format('M d, Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Payment Details</h6>
                                    <p class="card-text">
                                        <strong>Payment ID:</strong> {{ $purchase->razorpay_payment_id }}<br>
                                        <strong>Order ID:</strong> {{ $purchase->razorpay_order_id }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-success">{{ ucfirst($purchase->status) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="ri-information-line me-2"></i>
                        Your package has been successfully activated. You can now enjoy all the features included in your {{ $purchase->package_name }} package.
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('packages.index') }}" class="btn btn-primary">
                            <i class="ri-arrow-left-line me-2"></i>
                            Back to Packages
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                            <i class="ri-dashboard-line me-2"></i>
                            Go to Dashboard
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
