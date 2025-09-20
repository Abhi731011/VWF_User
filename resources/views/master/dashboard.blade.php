@extends('master.main')

@section('content')
<div class="dashboard-main-body">
    <!-- Welcome Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Welcome, {{ auth()->user() ? auth()->user()->name : 'User' }}!</h3>
                <p class="text-secondary-light mb-0">Welcome to your volunteer dashboard. Here you can manage your events, certificates, and kit status.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="volunteer-id-card">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2">
                        <span class="fw-semibold text-primary">Volunteer ID:</span>
                        <span class="badge bg-primary-light text-primary fw-semibold px-3 py-2">
                            {{ auth()->user() ? auth()->user()->volunteer_id : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1 gy-4 mb-24">
        <!-- Events Statistics -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center justify-content-between mb-16">
                        <div class="card-icon bg-success-subtle rounded-circle w-48-px h-48-px d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:calendar-outline" class="text-success-main"></iconify-icon>
                        </div>
                        <span class="badge bg-success-subtle text-success">Events</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-8">{{ $approvedRegistrations + $pendingRegistrations }}</h4>
                    <p class="text-secondary-light mb-0 small">Total Registrations</p>
                    <div class="mt-12">
                        <div class="d-flex justify-content-between small">
                            <span class="text-success">Approved: {{ $approvedRegistrations }}</span>
                            <span class="text-warning">Pending: {{ $pendingRegistrations }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donations Statistics -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center justify-content-between mb-16">
                        <div class="card-icon bg-primary-subtle rounded-circle w-48-px h-48-px d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:heart-outline" class="text-primary"></iconify-icon>
                        </div>
                        <span class="badge bg-primary-subtle text-primary">Donations</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-8">₹{{ number_format($totalDonated, 0) }}</h4>
                    <p class="text-secondary-light mb-0 small">Total Donated</p>
                    <div class="mt-12">
                        <div class="d-flex justify-content-between small">
                            <span class="text-primary">{{ $completedDonations }} Donations</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Statistics -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center justify-content-between mb-16">
                        <div class="card-icon bg-warning-subtle rounded-circle w-48-px h-48-px d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:shop-2-outline" class="text-warning-main"></iconify-icon>
                        </div>
                        <span class="badge bg-warning-subtle text-warning">Packages</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-8">₹{{ number_format($totalPackageSpent, 0) }}</h4>
                    <p class="text-secondary-light mb-0 small">Total Spent</p>
                    <div class="mt-12">
                        <div class="d-flex justify-content-between small">
                            <span class="text-warning">{{ $completedPurchases }} Purchases</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Certificates Statistics -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center justify-content-between mb-16">
                        <div class="card-icon bg-info-subtle rounded-circle w-48-px h-48-px d-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:diploma-verified-outline" class="text-info-main"></iconify-icon>
                        </div>
                        <span class="badge bg-info-subtle text-info">Certificates</span>
                    </div>
                    <h4 class="fw-bold text-dark mb-8">{{ $approvedCertificates + $pendingCertificates }}</h4>
                    <p class="text-secondary-light mb-0 small">Total Requests</p>
                    <div class="mt-12">
                        <div class="d-flex justify-content-between small">
                            <span class="text-success">Approved: {{ $approvedCertificates }}</span>
                            <span class="text-warning">Pending: {{ $pendingCertificates }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-4 mb-24">
        <!-- Register Event Card -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-32">
                    <div class="card-icon-wrapper mb-20">
                        <div class="card-icon bg-success-subtle">
                            <iconify-icon icon="solar:calendar-add-outline" class="text-success-main"></iconify-icon>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-12">Register Event</h5>
                    <p class="card-description text-secondary-light mb-24">Join upcoming volunteer events and make a difference in your community.</p>
                    <div class="card-stats mb-20">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="stats-label text-secondary-light">Available Events</span>
                            <span class="stats-value fw-bold text-success-main">{{ $availableEventsCount }}</span>
                        </div>
                    </div>
                    <a href="{{ route('events.index') }}" class="btn btn-success w-100 fw-semibold">
                        Register Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Donate to Projects Card -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-32">
                    <div class="card-icon-wrapper mb-20">
                        <div class="card-icon bg-primary-subtle">
                            <iconify-icon icon="solar:heart-outline" class="text-primary"></iconify-icon>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-12">Donate to Projects</h5>
                    <p class="card-description text-secondary-light mb-24">Support meaningful projects and make a positive impact in your community.</p>
                    <div class="card-stats mb-20">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="stats-label text-secondary-light">Available Projects</span>
                            <span class="stats-value fw-bold text-primary">{{ $availableProjectsCount }}</span>
                        </div>
                    </div>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary w-100 fw-semibold">
                        Donate Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Buy Packages Card -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-32">
                    <div class="card-icon-wrapper mb-20">
                        <div class="card-icon bg-warning-subtle">
                            <iconify-icon icon="solar:shop-2-outline" class="text-warning-main"></iconify-icon>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-12">Buy Packages</h5>
                    <p class="card-description text-secondary-light mb-24">Purchase volunteer packages and unlock exclusive benefits and features.</p>
                    <div class="card-stats mb-20">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="stats-label text-secondary-light">Available Packages</span>
                            <span class="stats-value fw-bold text-warning-main">{{ $availablePackagesCount }}</span>
                        </div>
                    </div>
                    <a href="{{ route('packages.index') }}" class="btn btn-warning w-100 fw-semibold">
                        View Packages
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="row mb-24">
        <div class="col-12">
            <div class="card shadow-sm border-0 dashboard-section-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:calendar-outline" class="text-primary me-3 section-header-icon"></iconify-icon>
                            <h5 class="fw-bold text-dark mb-0">Upcoming Events</h5>
                        </div>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body p-24">
                    @if($upcomingEvents->count() > 0)
                    <div class="row">
                            @foreach($upcomingEvents as $event)
                        <div class="col-md-6 mb-16">
                            <div class="event-item d-flex align-items-center justify-content-between p-16 bg-light rounded-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="event-icon bg-success-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:calendar-outline" class="text-success-main"></iconify-icon>
                                    </div>
                                    <div>
                                                <h6 class="fw-semibold mb-1">{{ $event->title }}</h6>
                                                <p class="text-secondary-light mb-0 small">{{ $event->event_date ? $event->event_date->format('M d, Y') : 'TBA' }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn-success btn-sm">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <iconify-icon icon="solar:calendar-outline" class="text-muted" style="font-size: 3rem;"></iconify-icon>
                            <p class="text-muted mt-2 mb-0">No upcoming events available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row mb-24">
        <div class="col-12">
            <div class="card shadow-sm border-0 dashboard-section-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:history-outline" class="text-info me-3 section-header-icon"></iconify-icon>
                            <h5 class="fw-bold text-dark mb-0">Recent Activity</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row">
                        <!-- Recent Event Registrations -->
                        @if($recentUserRegistrations->count() > 0)
                            <div class="col-md-6 mb-16">
                                <h6 class="fw-semibold text-dark mb-12">Recent Event Registrations</h6>
                                @foreach($recentUserRegistrations as $registration)
                                    <div class="activity-item d-flex align-items-center justify-content-between p-12 bg-light rounded-8 mb-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="activity-icon bg-success-subtle rounded-circle w-32-px h-32-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:calendar-outline" class="text-success-main" style="font-size: 0.875rem;"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1 small">{{ $registration->event->title ?? 'Event' }}</h6>
                                                <p class="text-secondary-light mb-0" style="font-size: 0.75rem;">{{ $registration->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="badge 
                                            @if($registration->status == 'approved') bg-success
                                            @elseif($registration->status == 'pending') bg-warning
                                            @elseif($registration->status == 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Recent Donations -->
                        @if($recentUserDonations->count() > 0)
                            <div class="col-md-6 mb-16">
                                <h6 class="fw-semibold text-dark mb-12">Recent Donations</h6>
                                @foreach($recentUserDonations as $donation)
                                    <div class="activity-item d-flex align-items-center justify-content-between p-12 bg-light rounded-8 mb-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="activity-icon bg-primary-subtle rounded-circle w-32-px h-32-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:heart-outline" class="text-primary" style="font-size: 0.875rem;"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1 small">{{ $donation->project_name }}</h6>
                                                <p class="text-secondary-light mb-0" style="font-size: 0.75rem;">₹{{ number_format($donation->amount, 0) }} • {{ $donation->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="badge 
                                            @if($donation->status == 'completed') bg-success
                                            @elseif($donation->status == 'pending') bg-warning
                                            @elseif($donation->status == 'failed') bg-danger
                                            @else bg-secondary
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Recent Package Purchases -->
                        @if($recentUserPurchases->count() > 0)
                            <div class="col-md-6 mb-16">
                                <h6 class="fw-semibold text-dark mb-12">Recent Package Purchases</h6>
                                @foreach($recentUserPurchases as $purchase)
                                    <div class="activity-item d-flex align-items-center justify-content-between p-12 bg-light rounded-8 mb-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="activity-icon bg-warning-subtle rounded-circle w-32-px h-32-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:shop-2-outline" class="text-warning-main" style="font-size: 0.875rem;"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1 small">{{ $purchase->package_name }}</h6>
                                                <p class="text-secondary-light mb-0" style="font-size: 0.75rem;">₹{{ number_format($purchase->amount, 0) }} • {{ $purchase->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="badge 
                                            @if($purchase->status == 'completed') bg-success
                                            @elseif($purchase->status == 'pending') bg-warning
                                            @elseif($purchase->status == 'failed') bg-danger
                                            @else bg-secondary
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Recent Certificate Requests -->
                        @if($recentUserCertificates->count() > 0)
                            <div class="col-md-6 mb-16">
                                <h6 class="fw-semibold text-dark mb-12">Recent Certificate Requests</h6>
                                @foreach($recentUserCertificates as $certificate)
                                    <div class="activity-item d-flex align-items-center justify-content-between p-12 bg-light rounded-8 mb-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="activity-icon bg-info-subtle rounded-circle w-32-px h-32-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:diploma-verified-outline" class="text-info-main" style="font-size: 0.875rem;"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1 small">Certificate Request</h6>
                                                <p class="text-secondary-light mb-0" style="font-size: 0.75rem;">{{ $certificate->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="badge 
                                            @if($certificate->status == 'approved') bg-success
                                            @elseif($certificate->status == 'pending') bg-warning
                                            @elseif($certificate->status == 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($certificate->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($recentUserRegistrations->count() == 0 && $recentUserDonations->count() == 0 && $recentUserPurchases->count() == 0 && $recentUserCertificates->count() == 0)
                        <div class="text-center py-4">
                            <iconify-icon icon="solar:history-outline" class="text-muted" style="font-size: 3rem;"></iconify-icon>
                            <p class="text-muted mt-2 mb-0">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Support & Quick Links Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 dashboard-section-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:headphones-round-outline" class="text-info me-3 section-header-icon"></iconify-icon>
                            <h5 class="fw-bold text-dark mb-0">Support & Quick Links</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row">
                        <!-- Support Tickets -->
                        <div class="col-md-6 mb-16">
                            <h6 class="fw-semibold text-dark mb-12">Support Tickets</h6>
                            @if($recentUserSupport->count() > 0)
                                @foreach($recentUserSupport as $support)
                                    <div class="support-item d-flex align-items-center justify-content-between p-12 bg-light rounded-8 mb-8">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="support-icon bg-info-subtle rounded-circle w-32-px h-32-px d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:headphones-round-outline" class="text-info-main" style="font-size: 0.875rem;"></iconify-icon>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold mb-1 small">{{ $support->subject }}</h6>
                                                <p class="text-secondary-light mb-0" style="font-size: 0.75rem;">{{ $support->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <span class="badge 
                                            @if($support->status == 'resolved') bg-success
                                            @elseif($support->status == 'in_progress') bg-warning
                                            @elseif($support->status == 'open') bg-primary
                                            @else bg-secondary
                                            @endif" style="font-size: 0.65rem;">
                                            {{ ucfirst($support->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-3">
                                    <iconify-icon icon="solar:headphones-round-outline" class="text-muted" style="font-size: 2rem;"></iconify-icon>
                                    <p class="text-muted mt-2 mb-0 small">No support tickets</p>
                                </div>
                            @endif
                        </div>

                        <!-- Quick Links -->
                        <div class="col-md-6 mb-16">
                            <h6 class="fw-semibold text-dark mb-12">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ route('events.index') }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-start">
                                    <iconify-icon icon="solar:calendar-outline" class="me-2"></iconify-icon>
                                    Browse Events
                                </a>
                                <a href="{{ route('projects.index') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-start">
                                    <iconify-icon icon="solar:heart-outline" class="me-2"></iconify-icon>
                                    View Projects
                                </a>
                                <a href="{{ route('packages.index') }}" class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-start">
                                    <iconify-icon icon="solar:shop-2-outline" class="me-2"></iconify-icon>
                                    Buy Packages
                                </a>
                                <a href="{{ route('certificates.index') }}" class="btn btn-outline-info btn-sm d-flex align-items-center justify-content-start">
                                    <iconify-icon icon="solar:diploma-verified-outline" class="me-2"></iconify-icon>
                                    Request Certificate
                                </a>
                                <a href="{{ route('support.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center justify-content-start">
                                    <iconify-icon icon="solar:headphones-round-outline" class="me-2"></iconify-icon>
                                    Get Support
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection
