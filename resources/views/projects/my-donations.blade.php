@extends('master.main')

@section('content')
@php
    $baseurl = 'http://localhost/ngo/public/';
@endphp

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="ri-heart-line me-2"></i>
                    My Donations
                </h2>
                <a href="{{ route('projects.index') }}" class="btn btn-primary">
                    <i class="ri-add-line me-2"></i>
                    Donate to More Projects
                </a>
            </div>

            @if($donations->count() > 0)
                <div class="row">
                    @foreach($donations as $donation)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100" style="border-radius: 15px; overflow: hidden;">
                                <div class="card-header text-white" style="background: linear-gradient(90deg, #28a745 0%, #20c997 100%); border-radius: 0;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $donation->project_name }}</h5>
                                        <span class="badge 
                                            @if($donation->status == 'completed') bg-success
                                            @elseif($donation->status == 'pending') bg-warning
                                            @elseif($donation->status == 'failed') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    @if($donation->project && $donation->project->images && count($donation->project->images) > 0)
                                        <div class="text-center mb-3">
                                            @php
                                                $firstImage = is_array($donation->project->images[0]) ? $donation->project->images[0]['url'] ?? $donation->project->images[0]['path'] ?? '' : $donation->project->images[0];
                                            @endphp
                                            @if($firstImage)
                                                <img src="{{ $baseurl . $firstImage }}" 
                                                     alt="{{ $donation->project_name }}" 
                                                     style="max-width: 150px; max-height: 150px; border-radius: 10px;">
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Donation Details</h6>
                                        <p class="mb-1"><strong>Amount:</strong> {{ $donation->currency }} {{ number_format($donation->amount, 2) }}</p>
                                        <p class="mb-1"><strong>Donor:</strong> {{ $donation->is_anonymous ? 'Anonymous' : $donation->donor_name }}</p>
                                        <p class="mb-1"><strong>Email:</strong> {{ $donation->donor_email }}</p>
                                        <p class="mb-1"><strong>Date:</strong> {{ $donation->created_at->format('M d, Y H:i') }}</p>
                                    </div>

                                    @if($donation->status == 'completed')
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Payment Details</h6>
                                            <p class="mb-1"><strong>Payment ID:</strong> {{ $donation->razorpay_payment_id }}</p>
                                            <p class="mb-1"><strong>Order ID:</strong> {{ $donation->razorpay_order_id }}</p>
                                        </div>
                                    @endif

                                    @if($donation->message)
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Your Message</h6>
                                            <p class="small">{{ Str::limit($donation->message, 100) }}</p>
                                        </div>
                                    @endif

                                    @if($donation->project && $donation->project->short_description)
                                        <div class="mb-3">
                                            <h6 class="text-muted mb-1">Project Description</h6>
                                            <p class="small">{{ Str::limit($donation->project->short_description, 120) }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="card-footer bg-transparent border-0">
                                    @if($donation->status == 'completed')
                                        <div class="d-grid">
                                            <button class="btn btn-success" disabled>
                                                <i class="ri-checkbox-circle-fill me-2"></i>
                                                Donation Completed
                                            </button>
                                        </div>
                                    @elseif($donation->status == 'pending')
                                        <div class="d-grid">
                                            <button class="btn btn-warning" disabled>
                                                <i class="ri-time-line me-2"></i>
                                                Payment Pending
                                            </button>
                                        </div>
                                    @elseif($donation->status == 'failed')
                                        <div class="d-grid">
                                            <a href="{{ route('projects.index') }}" class="btn btn-danger">
                                                <i class="ri-refresh-line me-2"></i>
                                                Retry Donation
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
                        <i class="ri-heart-line text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No Donations Yet</h4>
                    <p class="text-muted mb-4">You haven't made any donations yet. Explore our projects and make a difference in your community!</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-lg">
                        <i class="ri-heart-line me-2"></i>
                        Browse Projects
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
