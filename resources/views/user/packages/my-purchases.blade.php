@extends('master.main')

@section('content')
@php
    $baseurl = 'http://localhost/ngo/public/';
@endphp

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary mb-2"> My Package Purchases</h3>

                
                <a href="{{ route('packages.index') }}" class="btn btn-primary d-flex align-items-center">
                    <iconify-icon icon="solar:shop-2-outline" class="me-2" style="font-size: 1.1rem;"></iconify-icon>
                    Buy More Packages
                </a>
            </div>

            @if($purchases->count() > 0)
                <div class="row">
                    @foreach($purchases as $purchase)
                        <div class="col-12 col-md-6 col-lg-4 mb-4 mt-3">
                            <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden;">
                                <div class="card-header text-white" style="background:
                                    @if($purchase->package_name == 'Starter') linear-gradient(90deg, #ff512f 0%, #dd2476 100%);
                                    @elseif($purchase->package_name == 'Professional') linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
                                    @else linear-gradient(90deg, #f7971e 0%, #ffd200 100%);
                                    @endif
                                    border-radius: 0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $purchase->package_name }}</h5>
                                        <span class="badge 
                                            @if($purchase->status == 'completed') bg-success
                                            @elseif($purchase->status == 'pending') bg-warning
                                            @elseif($purchase->status == 'failed') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    @if($purchase->package && $purchase->package->image)
                                        <div class="text-center mb-3">
                                            <img src="{{ $baseurl . $purchase->package->image }}" 
                                                 alt="{{ $purchase->package_name }}" 
                                                 style="max-width: 150px; max-height: 150px; border-radius: 10px;">
                                        </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Purchase Details</h6>
                                        <p class="mb-1"><strong>Amount:</strong> {{ $purchase->currency }} {{ number_format($purchase->amount, 2) }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $purchase->email }}</p>
                                        <p class="mb-1"><strong>Purchase Date:</strong> {{ $purchase->created_at->format('M d, Y H:i') }}</p>
                                    </div>

                                    @if($purchase->status == 'completed')
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Payment Details</h6>
                                            <p class="mb-1"><strong>Payment ID:</strong> {{ $purchase->razorpay_payment_id }}</p>
                                            <p class="mb-1"><strong>Order ID:</strong> {{ $purchase->razorpay_order_id }}</p>
                                        </div>
                                    @endif

                                    @if($purchase->package && $purchase->package->description)
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Description</h6>
                                            <p class="small">{{ $purchase->package->description }}</p>
                                        </div>
                                    @endif

                                    @if($purchase->package && $purchase->package->perks)
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Package Features</h6>
                                            <ul class="list-unstyled small">
                                                @foreach(array_slice($purchase->package->perks, 0, 3) as $perk)
                                                    <li class="d-flex align-items-center mb-1">
                                                        <div class="me-2 d-flex align-items-center justify-content-center" style="width: 16px; height: 16px; background-color: #38ef7d; border-radius: 50%; flex-shrink: 0;">
                                                            <iconify-icon icon="solar:check-circle-bold" style="color: white; font-size: 0.7rem;"></iconify-icon>
                                                        </div>
                                                        <span>{{ $perk }}</span>
                                                    </li>
                                                @endforeach
                                                @if(count($purchase->package->perks) > 3)
                                                    <li class="text-muted">
                                                        <small>+{{ count($purchase->package->perks) - 3 }} more features</small>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-footer bg-transparent border-0">
                                    @if($purchase->status == 'completed')
                                        <div class="d-grid">
                                            <button class="btn btn-success d-flex align-items-center justify-content-center" disabled>
                                                <iconify-icon icon="solar:check-circle-bold" class="me-2" style="font-size: 1.1rem;"></iconify-icon>
                                                Package Active
                                            </button>
                                        </div>
                                    @elseif($purchase->status == 'pending')
                                        <div class="d-grid">
                                            <button class="btn btn-warning d-flex align-items-center justify-content-center" disabled>
                                                <iconify-icon icon="solar:clock-circle-outline" class="me-2" style="font-size: 1.1rem;"></iconify-icon>
                                                Payment Pending
                                            </button>
                                        </div>
                                    @elseif($purchase->status == 'failed')
                                        <div class="d-grid">
                                            <a href="{{ route('packages.index') }}" class="btn btn-danger d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:refresh-outline" class="me-2" style="font-size: 1.1rem;"></iconify-icon>
                                                Retry Payment
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <iconify-icon icon="solar:bag-4-outline" class="text-muted" style="font-size: 4rem;"></iconify-icon>
                    </div>
                    <h4 class="text-muted mb-3">No Package Purchases Yet</h4>
                    <p class="text-muted mb-4">You haven't purchased any packages yet. Explore our available packages and get started!</p>
                    <a href="{{ route('packages.index') }}" class="btn btn-primary btn-lg d-flex align-items-center justify-content-center mx-auto" style="width: fit-content;">
                        <iconify-icon icon="solar:shop-2-outline" class="me-2" style="font-size: 1.2rem;"></iconify-icon>
                        Browse Packages
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    @media (max-width: 576px) {
        .card {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endsection
