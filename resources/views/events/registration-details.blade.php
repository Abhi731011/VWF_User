@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="registration-details-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Registration Details</h3>
                <p class="text-secondary-light mb-0">View your event registration information.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('events.my-registrations') }}" class="btn btn-outline-secondary d-inline-flex align-items-center" style="width: fit-content !important;">
                    <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                    Back to My Registrations
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Event Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">Event Information</h5>
                </div>
                <div class="card-body p-24">
                    <h4 class="fw-bold text-dark mb-16">{{ $eventRegistration->event->title }}</h4>
                    
                    @if($eventRegistration->event->banners && count($eventRegistration->event->banners) > 0)
                        <img src="{{ $baseurl }}/{{ $eventRegistration->event->banners[0] }}" class="img-fluid rounded mb-16" alt="{{ $eventRegistration->event->title }}">
                    @endif
                    
                    <div class="event-info">
                        <div class="d-flex align-items-center mb-12">
                            <iconify-icon icon="solar:calendar-outline" class="text-primary me-3"></iconify-icon>
                            <div>
                                <div class="fw-semibold text-dark">{{ $eventRegistration->event->event_date->format('l, F j, Y') }}</div>
                                @if($eventRegistration->event->event_time)
                                    <div class="text-secondary-light small">{{ $eventRegistration->event->event_time }}</div>
                                @endif
                            </div>
                        </div>
                        
                        @if($eventRegistration->event->venue)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:map-point-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $eventRegistration->event->venue }}</div>
                                    @if($eventRegistration->event->location)
                                        <div class="text-secondary-light small">{{ $eventRegistration->event->location }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($eventRegistration->event->organizer_name)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:user-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">Organizer</div>
                                    <div class="text-secondary-light small">{{ $eventRegistration->event->organizer_name }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($eventRegistration->event->contact_email)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:letter-unread-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">Contact Email</div>
                                    <div class="text-secondary-light small">{{ $eventRegistration->event->contact_email }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($eventRegistration->event->contact_phone)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:phone-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">Contact Phone</div>
                                    <div class="text-secondary-light small">{{ $eventRegistration->event->contact_phone }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($eventRegistration->event->description)
                        <div class="event-description mt-20">
                            <h6 class="fw-semibold text-dark mb-8">Description</h6>
                            <p class="text-secondary-light small">{{ $eventRegistration->event->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Registration Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-bold">Your Registration</h5>
                </div>
                <div class="card-body p-24">
                    <!-- Status -->
                    <div class="mb-20">
                        <h6 class="fw-semibold text-dark mb-8">Registration Status</h6>
                        @if($eventRegistration->status === 'pending')
                            <span class="badge bg-warning text-dark fs-6 d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                Pending Review
                            </span>
                        @elseif($eventRegistration->status === 'approved')
                            <span class="badge bg-success text-white fs-6 d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                Approved
                            </span>
                        @elseif($eventRegistration->status === 'rejected')
                            <span class="badge bg-danger text-white fs-6 d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                Rejected
                            </span>
                        @elseif($eventRegistration->status === 'cancelled')
                            <span class="badge bg-secondary text-white fs-6 d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:minus-circle-outline" class="me-1"></iconify-icon>
                                Cancelled
                            </span>
                        @endif
                    </div>
                    
                    <!-- Registration Date -->
                    <div class="mb-20">
                        <h6 class="fw-semibold text-dark mb-8">Registration Date</h6>
                        <p class="text-secondary-light mb-0">{{ $eventRegistration->registered_at->format('l, F j, Y g:i A') }}</p>
                    </div>
                    
                    <!-- Personal Information -->
                    <div class="mb-20">
                        <h6 class="fw-semibold text-dark mb-12">Personal Information</h6>
                        <div class="row">
                            <div class="col-12 mb-8">
                                <div class="fw-semibold text-dark">Full Name</div>
                                <div class="text-secondary-light">{{ $eventRegistration->full_name }}</div>
                            </div>
                            <div class="col-12 mb-8">
                                <div class="fw-semibold text-dark">Email</div>
                                <div class="text-secondary-light">{{ $eventRegistration->email }}</div>
                            </div>
                            <div class="col-12 mb-8">
                                <div class="fw-semibold text-dark">Phone</div>
                                <div class="text-secondary-light">{{ $eventRegistration->phone }}</div>
                            </div>
                            @if($eventRegistration->address)
                                <div class="col-12 mb-8">
                                    <div class="fw-semibold text-dark">Address</div>
                                    <div class="text-secondary-light">{{ $eventRegistration->address }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Emergency Contact -->
                    @if($eventRegistration->emergency_contact_name || $eventRegistration->emergency_contact_phone)
                        <div class="mb-20">
                            <h6 class="fw-semibold text-dark mb-12">Emergency Contact</h6>
                            <div class="row">
                                @if($eventRegistration->emergency_contact_name)
                                    <div class="col-12 mb-8">
                                        <div class="fw-semibold text-dark">Contact Name</div>
                                        <div class="text-secondary-light">{{ $eventRegistration->emergency_contact_name }}</div>
                                    </div>
                                @endif
                                @if($eventRegistration->emergency_contact_phone)
                                    <div class="col-12 mb-8">
                                        <div class="fw-semibold text-dark">Contact Phone</div>
                                        <div class="text-secondary-light">{{ $eventRegistration->emergency_contact_phone }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- Special Requirements -->
                    @if($eventRegistration->special_requirements)
                        <div class="mb-20">
                            <h6 class="fw-semibold text-dark mb-8">Special Requirements</h6>
                            <p class="text-secondary-light">{{ $eventRegistration->special_requirements }}</p>
                        </div>
                    @endif
                    
                    <!-- Motivation -->
                    @if($eventRegistration->motivation)
                        <div class="mb-20">
                            <h6 class="fw-semibold text-dark mb-8">Motivation</h6>
                            <p class="text-secondary-light">{{ $eventRegistration->motivation }}</p>
                        </div>
                    @endif
                    
                    <!-- Admin Notes -->
                    @if($eventRegistration->admin_notes)
                        <div class="mb-20">
                            <h6 class="fw-semibold text-dark mb-8">Admin Notes</h6>
                            <div class="alert alert-info">
                                {{ $eventRegistration->admin_notes }}
                            </div>
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="d-flex gap-2">
                        @if(in_array($eventRegistration->status, ['pending', 'approved']))
                            <form action="{{ route('events.registration.cancel', $eventRegistration) }}" method="POST" class="flex-grow-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center" 
                                        onclick="return confirm('Are you sure you want to cancel this registration?')">
                                    <iconify-icon icon="solar:close-circle-outline" class="me-2"></iconify-icon>
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
@endsection
