@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="event-registration-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Register for Event</h3>
                <p class="text-secondary-light mb-0">Complete the form below to register for this event.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                    Back to Events
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Event Details Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">Event Details</h5>
                </div>
                <div class="card-body p-24">
                    <h4 class="fw-bold text-dark mb-16">{{ $event->title }}</h4>
                    
                    @if($event->banners && count($event->banners) > 0)
                        <img src="{{ $baseurl }}/{{ $event->banners[0] }}" class="img-fluid rounded mb-16" alt="{{ $event->title }}">
                    @endif
                    
                    <div class="event-info mb-16">
                        <div class="d-flex align-items-center mb-12">
                            <iconify-icon icon="solar:calendar-outline" class="text-primary me-3"></iconify-icon>
                            <div>
                                <div class="fw-semibold text-dark">{{ $event->event_date->format('l, F j, Y') }}</div>
                                @if($event->event_time)
                                    <div class="text-secondary-light small">{{ $event->event_time }}</div>
                                @endif
                            </div>
                        </div>
                        
                        @if($event->venue)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:map-point-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $event->venue }}</div>
                                    @if($event->location)
                                        <div class="text-secondary-light small">{{ $event->location }}</div>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($event->max_attendees)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:users-group-rounded-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">Capacity: {{ $event->max_attendees }} attendees</div>
                                    <div class="text-secondary-light small">
                                        {{ $event->registrations()->where('status', '!=', 'cancelled')->count() }} already registered
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($event->registration_deadline)
                            <div class="d-flex align-items-center mb-12">
                                <iconify-icon icon="solar:clock-outline" class="text-primary me-3"></iconify-icon>
                                <div>
                                    <div class="fw-semibold text-dark">Registration Deadline</div>
                                    <div class="text-secondary-light small">{{ $event->registration_deadline->format('M j, Y g:i A') }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    @if($event->short_description)
                        <div class="event-description">
                            <h6 class="fw-semibold text-dark mb-8">Description</h6>
                            <p class="text-secondary-light small">{{ $event->short_description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-bold">Registration Form</h5>
                </div>
                <div class="card-body p-32">
                    <form action="{{ route('events.store', $event) }}" method="POST">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="row mb-24">
                            <div class="col-12">
                                <h6 class="fw-semibold text-dark mb-16 border-bottom pb-8">Personal Information</h6>
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="full_name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name', auth()->user()->name) }}" required>
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" placeholder="Enter your full address">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="row mb-24">
                            <div class="col-12">
                                <h6 class="fw-semibold text-dark mb-16 border-bottom pb-8">Emergency Contact</h6>
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="emergency_contact_name" class="form-label fw-semibold">Emergency Contact Name</label>
                                <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                                       id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}">
                                @error('emergency_contact_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-16">
                                <label for="emergency_contact_phone" class="form-label fw-semibold">Emergency Contact Phone</label>
                                <input type="tel" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                                       id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}">
                                @error('emergency_contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mb-24">
                            <div class="col-12">
                                <h6 class="fw-semibold text-dark mb-16 border-bottom pb-8">Additional Information</h6>
                            </div>
                            
                            <div class="col-12 mb-16">
                                <label for="special_requirements" class="form-label fw-semibold">Special Requirements</label>
                                <textarea class="form-control @error('special_requirements') is-invalid @enderror" 
                                          id="special_requirements" name="special_requirements" rows="3" 
                                          placeholder="Any special dietary requirements, accessibility needs, etc.">{{ old('special_requirements') }}</textarea>
                                @error('special_requirements')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-16">
                                <label for="motivation" class="form-label fw-semibold">Why do you want to participate in this event?</label>
                                <textarea class="form-control @error('motivation') is-invalid @enderror" 
                                          id="motivation" name="motivation" rows="4" 
                                          placeholder="Tell us about your motivation to join this event...">{{ old('motivation') }}</textarea>
                                @error('motivation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-success fw-semibold d-flex align-items-center">
                                <iconify-icon icon="solar:user-plus-outline" class="me-2"></iconify-icon>
                                Submit Registration
                            </button>
                            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
