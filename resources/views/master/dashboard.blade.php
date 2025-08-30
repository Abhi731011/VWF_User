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
                            {{ auth()->user() ? auth()->user()->id : 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Cards Section -->
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
                            <span class="stats-value fw-bold text-success-main">12</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-success w-100 fw-semibold">
                        Register Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Claim Certificate Card -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-32">
                    <div class="card-icon-wrapper mb-20">
                        <div class="card-icon bg-warning-subtle">
                            <iconify-icon icon="solar:diploma-verified-outline" class="text-warning-main"></iconify-icon>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-12">Claim Certificate</h5>
                    <p class="card-description text-secondary-light mb-24">Get your volunteer certificates and showcase your achievements.</p>
                    <div class="card-stats mb-20">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="stats-label text-secondary-light">Pending Claims</span>
                            <span class="stats-value fw-bold text-warning-main">3</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-warning w-100 fw-semibold">
                        Claim Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Kit Status Card -->
        <div class="col">
            <div class="card shadow-sm border-0 h-100 dashboard-card">
                <div class="card-body p-32">
                    <div class="card-icon-wrapper mb-20">
                        <div class="card-icon bg-info-subtle">
                            <iconify-icon icon="solar:bag-4-outline" class="text-info-main"></iconify-icon>
                        </div>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-12">Kit Status</h5>
                    <p class="card-description text-secondary-light mb-24">Check the status of your volunteer kit and equipment.</p>
                    <div class="card-stats mb-20">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="stats-label text-secondary-light">Kit Status</span>
                            <span class="stats-value fw-bold text-success-main">Delivered</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-info w-100 fw-semibold">
                        View Details
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
                        <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row">
                        <div class="col-md-6 mb-16">
                            <div class="event-item d-flex align-items-center justify-content-between p-16 bg-light rounded-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="event-icon bg-success-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:tree-outline" class="text-success-main"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Tree Plantation Drive</h6>
                                        <p class="text-secondary-light mb-0 small">31 Aug 2024</p>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-success btn-sm">Join</a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-16">
                            <div class="event-item d-flex align-items-center justify-content-between p-16 bg-light rounded-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="event-icon bg-warning-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:heart-outline" class="text-warning-main"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Animal Shelter Volunteering</h6>
                                        <p class="text-secondary-light mb-0 small">3 Sep 2024</p>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-warning btn-sm">Join</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Achievements Section -->
    <div class="row mb-24">
        <div class="col-12">
            <div class="card shadow-sm border-0 dashboard-section-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                          <iconify-icon icon="mdi:star-circle-outline" class="text-warning me-3 section-header-icon"></iconify-icon>

                            <h5 class="fw-bold text-dark mb-0">Recent Achievements</h5>
                        </div>
                        <a href="#" class="btn btn-outline-warning btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row">
                        <div class="col-md-6 mb-16">
                            <div class="achievement-item d-flex align-items-center justify-content-between p-16 bg-light rounded-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="achievement-icon bg-primary-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:diploma-verified-outline" class="text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Independence Day Campaign</h6>
                                        <p class="text-secondary-light mb-0 small">Certificate Earned</p>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Download</a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-16">
                            <div class="achievement-item d-flex align-items-center justify-content-between p-16 bg-light rounded-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="achievement-icon bg-primary-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center">
                                        <iconify-icon icon="solar:diploma-verified-outline" class="text-primary"></iconify-icon>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold mb-1">Independence Day Campaign</h6>
                                        <p class="text-secondary-light mb-0 small">Certificate Earned</p>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-primary btn-sm">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 dashboard-section-card">
                <div class="card-header bg-transparent border-bottom">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <iconify-icon icon="solar:bell-outline" class="text-info me-3 section-header-icon"></iconify-icon>
                            <h5 class="fw-bold text-dark mb-0">Announcements</h5>
                        </div>
                        <a href="#" class="btn btn-outline-info btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="row">
                        <div class="col-md-6 mb-16">
                            <div class="announcement-item d-flex align-items-start gap-3 p-16 bg-light rounded-12">
                                <div class="announcement-icon bg-info-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center flex-shrink-0">
                                    <iconify-icon icon="solar:info-circle-outline" class="text-info"></iconify-icon>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1">Onboarding Kit Required</h6>
                                    <p class="text-secondary-light mb-0 small">All volunteers must complete onboarding kit before Sept 15.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-16">
                            <div class="announcement-item d-flex align-items-start gap-3 p-16 bg-light rounded-12">
                                <div class="announcement-icon bg-success-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center flex-shrink-0">
                                    <iconify-icon icon="solar:map-point-outline" class="text-success-main"></iconify-icon>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1">New Project Launched</h6>
                                    <p class="text-secondary-light mb-0 small">New project launched in Kanpur district.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection
