@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="my-registrations-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">My Event Registrations</h3>
                <p class="text-secondary-light mb-0">View and manage your event registrations.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('events.index') }}" class="btn btn-primary">
                    <iconify-icon icon="solar:calendar-add-outline" class="me-2"></iconify-icon>
                    Browse Events
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:check-circle-outline" class="me-2"></iconify-icon>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <iconify-icon icon="solar:danger-circle-outline" class="me-2"></iconify-icon>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Registrations List -->
    @if($registrations->count() > 0)
        <div class="row">
            @foreach($registrations as $registration)
                <div class="col-12 mb-16">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-24">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="d-flex align-items-start gap-3">
                                        @if($registration->event->banners && count($registration->event->banners) > 0)
                                            <img src="{{ $baseurl }}/{{ $registration->event->banners[0] }}" class="event-thumbnail" alt="{{ $registration->event->title }}">
                                        @else
                                            <div class="event-thumbnail-placeholder d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:calendar-outline" class="text-muted"></iconify-icon>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold text-dark mb-8">{{ $registration->event->title }}</h5>
                                            
                                            <div class="event-details mb-12">
                                                <div class="d-flex align-items-center mb-4">
                                                    <iconify-icon icon="solar:calendar-outline" class="text-primary me-2"></iconify-icon>
                                                    <span class="text-dark fw-semibold">{{ $registration->event->event_date->format('M j, Y') }}</span>
                                                </div>
                                                
                                                @if($registration->event->venue)
                                                    <div class="d-flex align-items-center mb-4">
                                                        <iconify-icon icon="solar:map-point-outline" class="text-primary me-2"></iconify-icon>
                                                        <span class="text-dark fw-semibold">{{ $registration->event->venue }}</span>
                                                    </div>
                                                @endif
                                                
                                                <div class="d-flex align-items-center mb-4">
                                                    <iconify-icon icon="solar:clock-outline" class="text-primary me-2"></iconify-icon>
                                                    <span class="text-secondary-light">Registered on {{ $registration->registered_at->format('M j, Y g:i A') }}</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            <div class="mb-12">
                                                @if($registration->status === 'pending')
                                                    <span class="badge bg-warning text-dark">
                                                        <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                                        Pending Review
                                                    </span>
                                                @elseif($registration->status === 'approved')
                                                    <span class="badge bg-success text-white">
                                                        <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                                        Approved
                                                    </span>
                                                @elseif($registration->status === 'rejected')
                                                    <span class="badge bg-danger text-white">
                                                        <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                                        Rejected
                                                    </span>
                                                @elseif($registration->status === 'cancelled')
                                                    <span class="badge bg-secondary text-white">
                                                        <iconify-icon icon="solar:minus-circle-outline" class="me-1"></iconify-icon>
                                                        Cancelled
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            @if($registration->admin_notes)
                                                <div class="alert alert-info mb-0">
                                                    <strong>Admin Note:</strong> {{ $registration->admin_notes }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 text-lg-end">
                                    <div class="d-flex flex-column gap-2">
                                        <a href="{{ route('events.registration.show', $registration) }}" class="btn btn-outline-primary btn-sm">
                                            <iconify-icon icon="solar:eye-outline" class="me-1"></iconify-icon>
                                            View Details
                                        </a>
                                        
                                        @if(in_array($registration->status, ['pending', 'approved']))
                                            <form action="{{ route('events.registration.cancel', $registration) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                        onclick="return confirm('Are you sure you want to cancel this registration?')">
                                                    <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                                    Cancel Registration
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $registrations->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <iconify-icon icon="solar:user-check-outline" class="text-muted mb-3" style="font-size: 4rem;"></iconify-icon>
            <h4 class="text-muted mb-3">No Registrations Found</h4>
            <p class="text-secondary-light mb-4">You haven't registered for any events yet.</p>
            <a href="{{ route('events.index') }}" class="btn btn-primary">
                <iconify-icon icon="solar:calendar-add-outline" class="me-2"></iconify-icon>
                Browse Available Events
            </a>
        </div>
    @endif
</div>

<style>
.event-thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
}

.event-thumbnail-placeholder {
    width: 80px;
    height: 80px;
    background-color: #f8f9fa;
    border-radius: 8px;
    font-size: 1.5rem;
}

.event-details {
    font-size: 0.9rem;
}
</style>
@endsection
