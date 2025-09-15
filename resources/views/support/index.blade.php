@extends('master.main')

@section('content')
<div class="support-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Support & Feedback</h3>
                <p class="text-secondary-light mb-0">We're here to help! Get support, share feedback, or report issues.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="support-info-card">
                    <div class="d-flex align-items-center justify-content-lg-end gap-2">
                        <iconify-icon icon="solar:headphones-round-outline" class="text-primary" style="font-size: 1.5rem;"></iconify-icon>
                        <span class="fw-semibold text-primary">24/7 Support</span>
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

    <!-- My Support Requests Section -->
    @if($supportRequests->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:list-outline" class="me-2"></iconify-icon>
                        My Support Requests
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Type</th>
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supportRequests as $request)
                                <tr>
                                    <td>
                                        <span class="fw-semibold text-primary">#{{ $request->id }}</span>
                                    </td>
                                    <td>
                                        <span class="{{ $request->getTypeBadgeClass() }}">
                                            {{ ucfirst(str_replace('_', ' ', $request->type)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $request->subject }}">
                                            {{ $request->subject }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="{{ $request->getPriorityBadgeClass() }}">
                                            {{ ucfirst($request->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="{{ $request->getStatusBadgeClass() }}">
                                            {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $request->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('support.show', $request) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                            <iconify-icon icon="solar:eye-outline" class="me-1"></iconify-icon>
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($supportRequests->hasPages())
                    <div class="card-footer">
                        {{ $supportRequests->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Contact Form -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:chat-round-dots-outline" class="me-2"></iconify-icon>
                        Send us a Message
                    </h5>
                </div>
                <div class="card-body p-32">
                    <form action="{{ route('support.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Type Selection -->
                            <div class="col-md-6 mb-20">
                                <label for="type" class="form-label fw-semibold text-dark">Request Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select request type</option>
                                    <option value="support" {{ old('type') == 'support' ? 'selected' : '' }}>Technical Support</option>
                                    <option value="feedback" {{ old('type') == 'feedback' ? 'selected' : '' }}>General Feedback</option>
                                    <option value="bug_report" {{ old('type') == 'bug_report' ? 'selected' : '' }}>Bug Report</option>
                                    <option value="feature_request" {{ old('type') == 'feature_request' ? 'selected' : '' }}>Feature Request</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Priority Selection -->
                            <div class="col-md-6 mb-20">
                                <label for="priority" class="form-label fw-semibold text-dark">Priority <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                    <option value="">Select priority</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="mb-20">
                            <label for="category" class="form-label fw-semibold text-dark">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" 
                                   placeholder="e.g., Account Issues, Event Registration, Payment, etc." 
                                   value="{{ old('category') }}" required>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div class="mb-20">
                            <label for="subject" class="form-label fw-semibold text-dark">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" 
                                   placeholder="Brief description of your request" 
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="mb-24">
                            <label for="message" class="form-label fw-semibold text-dark">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" 
                                      rows="6" placeholder="Please provide detailed information about your request..." required>{{ old('message') }}</textarea>
                            <div class="form-text">Maximum 2000 characters</div>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:letter-unread-outline" class="me-2"></iconify-icon>
                                Send Message
                            </button>
                            <button type="reset" class="btn btn-outline-secondary d-inline-flex align-items-center" style="width: fit-content !important;">
                                <iconify-icon icon="solar:refresh-outline" class="me-2"></iconify-icon>
                                Reset
                            </button>
                        </div>
                    </form>
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

            <!-- FAQ Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0 fw-bold d-inline-flex align-items-center">
                        <iconify-icon icon="solar:question-circle-outline" class="me-2"></iconify-icon>
                        Quick Help
                    </h5>
                </div>
                <div class="card-body p-24">
                    <div class="faq-list">
                        <div class="faq-item mb-16">
                            <h6 class="fw-semibold text-dark mb-2">How do I register for events?</h6>
                            <p class="text-secondary-light small mb-0">Go to the Events page, select your preferred event, and click "Register Now".</p>
                        </div>
                        
                        <div class="faq-item mb-16">
                            <h6 class="fw-semibold text-dark mb-2">Can I cancel my registration?</h6>
                            <p class="text-secondary-light small mb-0">Yes, you can cancel your registration from the "My Registrations" page.</p>
                        </div>
                        
                        <div class="faq-item mb-16">
                            <h6 class="fw-semibold text-dark mb-2">How do I update my profile?</h6>
                            <p class="text-secondary-light small mb-0">Visit your profile page and click "Edit Profile" to update your information.</p>
                        </div>
                        
                        <div class="faq-item">
                            <h6 class="fw-semibold text-dark mb-2">Where can I find my certificates?</h6>
                            <p class="text-secondary-light small mb-0">Certificates will be available in your dashboard once you complete events.</p>
                        </div>
                    </div>
                    
                    <div class="mt-20">
                        <a href="#" class="btn btn-outline-info w-100 d-inline-flex align-items-center justify-content-center">
                            <iconify-icon icon="solar:book-open-outline" class="me-2"></iconify-icon>
                            View Full FAQ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.support-info-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 16px 20px;
    border-radius: 12px;
    border: 1px solid #dee2e6;
}

.contact-info .contact-icon {
    flex-shrink: 0;
}

.faq-item {
    border-bottom: 1px solid #f1f3f4;
    padding-bottom: 12px;
}

.faq-item:last-child {
    border-bottom: none;
    margin-bottom: 0 !important;
    padding-bottom: 0;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn {
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-1px);
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
