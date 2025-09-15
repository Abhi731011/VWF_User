@extends('master.main')

@section('content')
<div class="support-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Support Request Details</h3>
                <p class="text-secondary-light mb-0">Ticket #{{ $supportFeedback->id }} - {{ $supportFeedback->subject }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('support.index') }}" class="btn btn-outline-primary d-inline-flex align-items-center">
                    <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                    Back to Support
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Support Request Details -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:document-text-outline" class="me-2"></iconify-icon>
                        Request Details
                    </h5>
                </div>
                <div class="card-body p-32">
                    <div class="row mb-20">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Request Type:</label>
                                <span class="{{ $supportFeedback->getTypeBadgeClass() }} ms-2">
                                    {{ ucfirst(str_replace('_', ' ', $supportFeedback->type)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Priority:</label>
                                <span class="{{ $supportFeedback->getPriorityBadgeClass() }} ms-2">
                                    {{ ucfirst($supportFeedback->priority) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-20">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Status:</label>
                                <span class="{{ $supportFeedback->getStatusBadgeClass() }} ms-2">
                                    {{ ucfirst(str_replace('_', ' ', $supportFeedback->status)) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Category:</label>
                                <span class="text-secondary">{{ $supportFeedback->category }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-20">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Created:</label>
                                <span class="text-secondary">{{ $supportFeedback->created_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Last Updated:</label>
                                <span class="text-secondary">{{ $supportFeedback->updated_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    @if($supportFeedback->resolved_at)
                    <div class="row mb-20">
                        <div class="col-12">
                            <div class="info-item">
                                <label class="fw-semibold text-dark">Resolved:</label>
                                <span class="text-success">{{ $supportFeedback->resolved_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr class="my-24">

                    <div class="mb-20">
                        <label class="fw-semibold text-dark mb-2">Subject:</label>
                        <div class="p-16 bg-light rounded">
                            {{ $supportFeedback->subject }}
                        </div>
                    </div>

                    <div class="mb-20">
                        <label class="fw-semibold text-dark mb-2">Message:</label>
                        <div class="p-16 bg-light rounded">
                            {{ $supportFeedback->message }}
                        </div>
                    </div>

                    @if($supportFeedback->admin_response)
                    <div class="mb-20">
                        <label class="fw-semibold text-dark mb-2">Admin Response:</label>
                        <div class="p-16 bg-success-subtle rounded border-start border-success border-4">
                            {{ $supportFeedback->admin_response }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Support Information -->
        <div class="col-lg-4 mb-4">
            <!-- Contact Information -->
            <div class="card shadow-sm border-0 mb-24">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:phone-outline" class="me-2"></iconify-icon>
                        Contact Information
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="contact-info">
                        <div class="d-flex align-items-center mb-16">
                            <div class="contact-icon bg-primary-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                <iconify-icon icon="solar:letter-unread-outline" class="text-primary"></iconify-icon>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Email Support</div>
                                <div class="text-secondary-light small">info@vaishvikwelfare.org</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-16">
                            <div class="contact-icon bg-success-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                <iconify-icon icon="solar:phone-outline" class="text-success-main"></iconify-icon>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Phone Support</div>
                                <div class="text-secondary-light small">+91 7860333385</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-16">
                            <div class="contact-icon bg-warning-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                <iconify-icon icon="solar:clock-circle-outline" class="text-warning-main"></iconify-icon>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Response Time</div>
                                <div class="text-secondary-light small">12-24 hours</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="contact-icon bg-info-subtle rounded-circle w-40-px h-40-px d-flex align-items-center justify-content-center me-3">
                                <iconify-icon icon="solar:calendar-outline" class="text-info"></iconify-icon>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Business Hours</div>
                                <div class="text-secondary-light small">Mon-Fri 9AM-6PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:info-circle-outline" class="me-2"></iconify-icon>
                        Status Information
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="status-info">
                        <div class="mb-16">
                            <div class="fw-semibold text-dark mb-2">Current Status</div>
                            <span class="{{ $supportFeedback->getStatusBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $supportFeedback->status)) }}
                            </span>
                        </div>
                        
                        <div class="mb-16">
                            <div class="fw-semibold text-dark mb-2">Priority Level</div>
                            <span class="{{ $supportFeedback->getPriorityBadgeClass() }}">
                                {{ ucfirst($supportFeedback->priority) }}
                            </span>
                        </div>
                        
                        <div class="mb-16">
                            <div class="fw-semibold text-dark mb-2">Request Type</div>
                            <span class="{{ $supportFeedback->getTypeBadgeClass() }}">
                                {{ ucfirst(str_replace('_', ' ', $supportFeedback->type)) }}
                            </span>
                        </div>
                        
                        <div class="mb-16">
                            <div class="fw-semibold text-dark mb-2">Ticket ID</div>
                            <div class="text-primary fw-bold">#{{ $supportFeedback->id }}</div>
                        </div>
                        
                        <div class="mb-16">
                            <div class="fw-semibold text-dark mb-2">Created</div>
                            <div class="text-secondary">{{ $supportFeedback->created_at->format('M d, Y') }}</div>
                        </div>
                        
                        @if($supportFeedback->resolved_at)
                        <div>
                            <div class="fw-semibold text-dark mb-2">Resolved</div>
                            <div class="text-success">{{ $supportFeedback->resolved_at->format('M d, Y') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 12px;
}

.info-item label {
    display: block;
    margin-bottom: 4px;
}

.contact-info .contact-icon {
    flex-shrink: 0;
}

.status-info > div:last-child {
    margin-bottom: 0 !important;
}

.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}
</style>
@endsection
