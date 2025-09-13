@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="events-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Available Events</h3>
                <p class="text-secondary-light mb-0">Join our upcoming volunteer events and make a difference in your community.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('events.my-registrations') }}" class="btn btn-outline-primary d-inline-flex align-items-center">
                    My Registrations
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

    <!-- Events Grid -->
    @if($events->count() > 0)
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-4 mb-24">
            @foreach($events as $event)
                <div class="col">
                    <div class="card shadow-sm border-0 h-100 event-card">
                        @if($event->banners && count($event->banners) > 0)
                            <img src="{{ $baseurl }}/{{ $event->banners[0] }}" class="card-img-top event-banner" alt="{{ $event->title }}">
                        @else
                            <div class="card-img-top event-banner-placeholder d-flex align-items-center justify-content-center">
                                <iconify-icon icon="solar:calendar-outline" class="text-muted" style="font-size: 3rem;"></iconify-icon>
                            </div>
                        @endif
                        
                        <div class="card-body p-24 d-flex flex-column h-100">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between mb-16">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title fw-bold text-dark mb-8">{{ $event->title }}</h5>
                                        @if($event->category)
                                            <span class="badge bg-primary-light text-primary mb-12">{{ $event->category->name }}</span>
                                        @endif
                                    </div>
                                    @if($event->is_featured)
                                        <span class="badge bg-warning text-dark">
                                            <iconify-icon icon="solar:star-outline" class="me-1"></iconify-icon>
                                            Featured
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="card-text text-secondary-light mb-16 event-description">
                                    {{ Str::limit($event->short_description ?? $event->description, 120) }}
                                </p>
                                
                                <div class="event-details mb-20">
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:calendar-outline" class="text-primary me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">{{ $event->event_date->format('M j, Y') }}</span>
                                    </div>
                                    
                                    @if($event->event_time)
                                        <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="tabler:clock" class="text-primary me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">{{ $event->event_time }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($event->venue)
                                        <div class="d-flex align-items-center mb-8">
                                            <iconify-icon icon="solar:map-point-outline" class="text-primary me-2"></iconify-icon>
                                            <span class="text-dark fw-semibold">{{ $event->venue }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($event->max_attendees)
                                        <div class="d-flex align-items-center mb-8">
                                            <iconify-icon icon="solar:users-group-rounded-outline" class="text-primary me-2"></iconify-icon>
                                            <span class="text-dark fw-semibold">
                                                {{ $event->registrations()->where('status', '!=', 'cancelled')->count() }}/{{ $event->max_attendees }} registered
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 mt-auto">
                                @php
                                    $userRegistration = $event->registrations()->where('user_id', auth()->id())->first();
                                @endphp
                                
                                @if($userRegistration)
                                    <span class="btn bg-success text-white flex-grow-1 d-flex align-items-center justify-content-center py-2 fw-semibold">
                                        <iconify-icon icon="solar:check-circle-outline" class="me-2"></iconify-icon>
                                        Registered
                                    </span>
                                    <a href="{{ route('events.registration.show', $userRegistration) }}" class="btn btn-outline-success btn-sm">
                                        View Details
                                    </a>
                                @else
                                    <a href="{{ route('events.register', $event) }}" class="btn btn-primary w-100 fw-semibold">
                                        Register Now
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if(method_exists($events, 'links'))
            <div class="d-flex justify-content-center">
                {{ $events->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <iconify-icon icon="solar:calendar-outline" class="text-muted mb-3" style="font-size: 4rem;"></iconify-icon>
            <h4 class="text-muted mb-3">No Events Available</h4>
            <p class="text-secondary-light">There are currently no events available for registration. Check back later for new opportunities!</p>
        </div>
    @endif
</div>

<style>
.event-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.event-banner {
    height: 200px;
    object-fit: cover;
}

.event-banner-placeholder {
    height: 200px;
    background-color: #f8f9fa;
}

.event-details {
    font-size: 0.9rem;
}

.event-description {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
    max-height: calc(1.4em * 3);
}
</style>
@endsection
