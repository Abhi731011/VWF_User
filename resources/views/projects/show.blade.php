@extends('master.main')

@php
    $baseurl = 'http://localhost/ngo/public';
@endphp

@section('content')
<div class="project-detail-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">{{ $project->title }}</h3>
                <p class="text-secondary-light mb-0">{{ $project->short_description }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-primary d-inline-flex align-items-center">
                    <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                    Back to Projects
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Project Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:folder-outline" class="me-2"></iconify-icon>
                        Project Details
                    </h5>
                </div>
                <div class="card-body p-32">
                    <!-- Project Images -->
                    @if($project->images && count($project->images) > 0)
                        <div class="mb-24">
                            <div class="row">
                                @foreach($project->images as $index => $image)
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ $baseurl }}/{{ $image }}" class="img-fluid rounded shadow" alt="Project Image {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Project Description -->
                    <div class="mb-24">
                        <h6 class="fw-bold text-dark mb-3">About This Project</h6>
                        <div class="project-description">
                            {!! nl2br(e($project->description)) !!}
                        </div>
                    </div>

                    <!-- Project Video -->
                    @if($project->video_url)
                        <div class="mb-24">
                            <h6 class="fw-bold text-dark mb-3">Project Video</h6>
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $project->video_url }}" title="Project Video" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    <!-- Project Updates -->
                    @if($project->updates && count($project->updates) > 0)
                        <div class="mb-24">
                            <h6 class="fw-bold text-dark mb-3">Project Updates</h6>
                            <div class="project-updates">
                                @foreach($project->updates as $update)
                                    <div class="update-item mb-16 p-16 bg-light rounded">
                                        <div class="d-flex align-items-center mb-8">
                                            <iconify-icon icon="solar:calendar-outline" class="text-primary me-2"></iconify-icon>
                                            <span class="fw-semibold text-dark">{{ $update['date'] ?? 'Recent Update' }}</span>
                                        </div>
                                        <p class="mb-0 text-secondary">{{ $update['description'] ?? $update }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- FAQs -->
                    @if($project->faqs && count($project->faqs) > 0)
                        <div class="mb-24">
                            <h6 class="fw-bold text-dark mb-3">Frequently Asked Questions</h6>
                            <div class="accordion" id="faqAccordion">
                                @foreach($project->faqs as $index => $faq)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faqHeading{{ $index }}">
                                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" 
                                                    data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" 
                                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" 
                                                    aria-controls="faqCollapse{{ $index }}">
                                                {{ $faq['question'] ?? $faq }}
                                            </button>
                                        </h2>
                                        <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                             aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                {{ $faq['answer'] ?? 'No answer provided.' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Project Information Sidebar -->
        <div class="col-lg-4 mb-4">
            <!-- Project Summary -->
            <div class="card shadow-sm border-0 mb-24">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:info-circle-outline" class="me-2"></iconify-icon>
                        Project Summary
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="project-summary">
                        @if($project->category)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Category</div>
                                <span class="badge bg-primary-subtle text-primary">{{ $project->category->name }}</span>
                            </div>
                        @endif
                        
                        @if($project->target_amount)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Target Amount</div>
                                <div class="text-success fw-bold fs-5">₹{{ number_format($project->target_amount) }}</div>
                            </div>
                        @endif
                        
                        @if($project->min_donation)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Minimum Donation</div>
                                <div class="text-info fw-bold">₹{{ number_format($project->min_donation) }}</div>
                            </div>
                        @endif
                        
                        @if($project->end_date)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Project End Date</div>
                                <div class="text-warning fw-bold">{{ $project->end_date->format('M d, Y') }}</div>
                            </div>
                        @endif
                        
                        @if($project->location)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Location</div>
                                <div class="text-dark">{{ $project->location }}</div>
                            </div>
                        @endif
                        
                        @if($project->is_recurring)
                            <div class="mb-16">
                                <div class="fw-semibold text-dark mb-2">Project Type</div>
                                <span class="badge bg-info-subtle text-info">Recurring Project</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card shadow-sm border-0 mb-24">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:phone-outline" class="me-2"></iconify-icon>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="contact-info">
                        @if($project->organizer_name)
                            <div class="d-flex align-items-center mb-16">
                                <div class="contact-icon bg-primary-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                    <iconify-icon icon="solar:user-outline" class="text-primary"></iconify-icon>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Organizer</div>
                                    <div class="text-secondary-light small">{{ $project->organizer_name }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($project->contact_email)
                            <div class="d-flex align-items-center mb-16">
                                <div class="contact-icon bg-success-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                    <iconify-icon icon="solar:letter-unread-outline" class="text-success-main"></iconify-icon>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Email</div>
                                    <div class="text-secondary-light small">{{ $project->contact_email }}</div>
                                </div>
                            </div>
                        @endif
                        
                        @if($project->contact_phone)
                            <div class="d-flex align-items-center">
                                <div class="contact-icon bg-warning-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                    <iconify-icon icon="solar:phone-outline" class="text-warning-main"></iconify-icon>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Phone</div>
                                    <div class="text-secondary-light small">{{ $project->contact_phone }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:hand-money-outline" class="me-2"></iconify-icon>
                        Support This Project
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="text-center">
                        <p class="text-muted mb-16">Interested in supporting this project?</p>
                        <button class="btn btn-success btn-lg w-100 d-inline-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:hand-money-outline" class="me-2"></iconify-icon>
                            Donate Now
                        </button>
                        <small class="text-muted mt-2 d-block">Contact the organizer for donation details</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.project-description {
    line-height: 1.6;
    color: #495057;
}

.project-summary > div:last-child {
    margin-bottom: 0 !important;
}

.contact-info .contact-icon {
    flex-shrink: 0;
}

.update-item {
    border-left: 4px solid #0d6efd;
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
}

.card-body {
    padding: 2rem !important;
}

.card-header {
    padding: 1.5rem 2rem !important;
    border-bottom: 1px solid #e9ecef !important;
}

.accordion-button {
    font-weight: 600;
}

.accordion-body {
    background-color: #f8f9fa;
}

.img-fluid {
    border-radius: 8px;
}

.ratio {
    border-radius: 8px;
    overflow: hidden;
}
</style>
@endsection
