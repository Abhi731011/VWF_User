@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="projects-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Available Projects</h3>
                <p class="text-secondary-light mb-0">Discover our ongoing projects and contribute to meaningful causes in your community.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="projects-info-card">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2">
                        <iconify-icon icon="solar:folder-outline" class="text-primary" style="font-size: 1.5rem;"></iconify-icon>
                        <span class="fw-semibold text-primary">Active Projects</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <iconify-icon icon="solar:check-circle-outline" class="me-2"></iconify-icon>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <iconify-icon icon="solar:danger-circle-outline" class="me-2"></iconify-icon>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Projects Grid -->
    @if($projects->count() > 0)
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 gy-4 mb-24">
            @foreach($projects as $project)
                <div class="col">
                    <div class="card shadow-sm border-0 h-100 project-card">
                        <div class="project-image-container position-relative">
                            @if($project->images && count($project->images) > 0)
                                <img src="{{ $baseurl }}/{{ $project->images[0] }}" class="card-img-top project-banner" alt="{{ $project->title }}">
                            @else
                                <div class="card-img-top project-banner-placeholder d-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:folder-outline" style="font-size: 3rem; color: #6c757d;"></iconify-icon>
                                </div>
                            @endif
                            <!-- Donate Now Button -->
                            <div class="donate-button-overlay">
                                <button class="btn btn-success btn-sm donate-now-btn d-inline-flex align-items-center">
                                    <iconify-icon icon="solar:hand-money-outline" class="me-1"></iconify-icon>
                                    Donate Now
                                </button>
                            </div>
                        </div>
                        
                        <div class="card-body p-24">
                            <!-- Category Badge -->
                            @if($project->category)
                                <span class="badge bg-primary-subtle text-primary mb-16">{{ $project->category->name }}</span>
                            @endif
                            
                            <!-- Project Title -->
                            <h5 class="card-title fw-bold text-dark mb-12">{{ $project->title }}</h5>
                            
                            <!-- Short Description -->
                            <p class="card-text text-secondary-light mb-16">{{ Str::limit($project->short_description, 120) }}</p>
                            
                            <!-- Project Details -->
                            <div class="project-details mb-16">
                                @if($project->target_amount)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:dollar-minimalistic-outline" class="text-success me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Target: ₹{{ number_format($project->target_amount) }}</span>
                                    </div>
                                @endif
                                
                                @if($project->min_donation)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:hand-money-outline" class="text-info me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Min Donation: ₹{{ number_format($project->min_donation) }}</span>
                                    </div>
                                @endif
                                
                                @if($project->end_date)
                                    <div class="d-flex align-items-center mb-8">
                                        <iconify-icon icon="solar:calendar-outline" class="text-warning me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">Ends: {{ $project->end_date->format('M d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($project->location)
                                    <div class="d-flex align-items-center">
                                        <iconify-icon icon="solar:map-point-outline" class="text-danger me-2"></iconify-icon>
                                        <span class="text-dark fw-semibold">{{ $project->location }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent border-0 p-24 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-primary flex-fill d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="solar:eye-outline" class="me-2"></iconify-icon>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($projects->hasPages())
            <div class="d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        @endif
    @else
        <!-- No Projects Found -->
        <div class="text-center py-5">
            <iconify-icon icon="solar:folder-outline" style="font-size: 4rem; color: #6c757d;"></iconify-icon>
            <h5 class="mt-3">No Projects Available</h5>
            <p class="text-muted">There are currently no active projects to display.</p>
        </div>
    @endif
</div>

<style>
.projects-info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 16px 20px;
    border-radius: 12px;
    border: 1px solid #dee2e6;
}

.project-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.project-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.project-banner {
    height: 200px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}

.project-banner-placeholder {
    height: 200px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px 12px 0 0;
}

.project-image-container {
    overflow: hidden;
}

.donate-button-overlay {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 10;
}

.donate-now-btn {
    background: rgba(9, 58, 43, 0.9) !important;
    border: 1px solid rgba(9, 58, 43, 0.9) !important;
    color: white !important;
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    backdrop-filter: blur(5px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.donate-now-btn:hover {
    background: rgba(9, 58, 43, 1) !important;
    border-color: rgba(9, 58, 43, 1) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.project-details {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 8px;
    border-left: 4px solid #0d6efd;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.card-body {
    padding: 1.5rem !important;
}

.card-footer {
    padding: 1.5rem !important;
    padding-top: 0 !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.alert {
    margin-bottom: 1.5rem !important;
}
</style>
@endsection
