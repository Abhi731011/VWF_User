@extends('master.main')

@section('content')
<div class="dashboard-content-wrapper">
    <div class="dashboard-main-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                            <h4 class="dashboard-card-title">Certificate Request Details</h4>
                            <div>
                                <a href="{{ route('certificates.index') }}" class="btn btn-secondary me-2 d-inline-flex align-items-center" style="background-color: #6c757d !important; border-color: #6c757d !important;">
                                    <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                                    Back to Requests
                                </a>
                                @if($certificateRequest->status === 'pending')
                                    <span class="badge bg-warning fs-6 d-inline-flex align-items-center" style="height: 38px; padding: 0.5rem 1rem;">
                                        <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                        Pending Review
                                    </span>
                                @elseif($certificateRequest->status === 'approved')
                                    <span class="badge bg-success fs-6 d-inline-flex align-items-center" style="height: 38px; padding: 0.5rem 1rem;">
                                        <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                        Approved
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6 d-inline-flex align-items-center" style="height: 38px; padding: 0.5rem 1rem;">
                                        <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                        Rejected
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Request ID:</label>
                                            <p class="form-control-plaintext">#{{ $certificateRequest->id }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Submitted Date:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->created_at->format('M d, Y \a\t g:i A') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Full Name:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->full_name }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Email:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Phone:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->phone }}</p>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">ZIP Code:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->zip_code }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Address:</label>
                                        <p class="form-control-plaintext">{{ $certificateRequest->address }}</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">City:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->city }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">State:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->state }}</p>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Country:</label>
                                            <p class="form-control-plaintext">{{ $certificateRequest->country }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($certificateRequest->admin_notes)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Admin Notes:</label>
                                            <div class="alert alert-info">
                                                {{ $certificateRequest->admin_notes }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <label class="form-label fw-bold">Profile Image:</label>
                                        @if($certificateRequest->image_path)
                                            <div class="mb-3">
                                                <img src="{{ asset($certificateRequest->image_path) }}" 
                                                     alt="Profile Image" 
                                                     class="img-fluid rounded shadow"
                                                     style="max-height: 300px;">
                                            </div>
                                        @else
                                            <div class="text-muted">
                                                <iconify-icon icon="solar:image-outline" style="font-size: 3rem;"></iconify-icon>
                                                <p>No image uploaded</p>
                                            </div>
                                        @endif
                                    </div>
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

@push('css')
<style>
.dashboard-card-body {
    padding: 2rem !important;
}

.dashboard-card-header {
    padding: 1.5rem 2rem !important;
    border-bottom: 1px solid #e9ecef !important;
}

.dashboard-card-title {
    margin-bottom: 0 !important;
}

.form-label {
    margin-bottom: 0.5rem !important;
    display: block !important;
}

.form-control-plaintext {
    margin-bottom: 1rem !important;
    padding: 0.5rem 0 !important;
    border-bottom: 1px solid #e9ecef !important;
}

.row {
    margin-bottom: 1rem !important;
}

.row:last-child {
    margin-bottom: 0 !important;
}

.mb-3 {
    margin-bottom: 1rem !important;
}

.alert {
    margin-bottom: 1.5rem !important;
    padding: 1rem !important;
}

.btn {
    padding: 0.75rem 1.5rem !important;
    margin: 0.5rem !important;
}

.badge {
    padding: 0.5rem 1rem !important;
    margin: 0.25rem !important;
}

.text-center {
    padding: 1rem !important;
}

.img-fluid {
    margin: 1rem 0 !important;
    padding: 0.5rem !important;
    border: 1px solid #e9ecef !important;
    border-radius: 0.5rem !important;
}

.text-muted {
    padding: 2rem !important;
    margin: 1rem 0 !important;
}
</style>
@endpush
