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
                                <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary me-2">
                                    <iconify-icon icon="solar:arrow-left-outline" class="me-2"></iconify-icon>
                                    Back to Requests
                                </a>
                                @if($certificateRequest->status === 'pending')
                                    <span class="badge bg-warning fs-6">
                                        <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                        Pending Review
                                    </span>
                                @elseif($certificateRequest->status === 'approved')
                                    <span class="badge bg-success fs-6">
                                        <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                        Approved
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
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
