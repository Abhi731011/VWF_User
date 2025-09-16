@extends('master.main')

@section('content')
<div class="dashboard-content-wrapper">
    <div class="dashboard-main-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h4 class="dashboard-card-title">Certificate Request</h4>
                        </div>
                        <div class="dashboard-card-body">
                            @if(!$isEligible)
                                <div class="alert alert-warning" role="alert">
                                    <iconify-icon icon="solar:danger-circle-outline" class="me-2"></iconify-icon>
                                    <strong>Not Eligible:</strong> You need to be registered for at least 30 days to request a certificate.
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" onclick="showNotEligibleAlert()">
                                        Request Certificate
                                    </button>
                                </div>
                            @elseif($existingRequest)
                                <div class="alert alert-info" role="alert">
                                    <iconify-icon icon="solar:info-circle-outline" class="me-2"></iconify-icon>
                                    <strong>Request Status:</strong> 
                                    @if($existingRequest->status === 'pending')
                                        Your certificate request is currently pending review.
                                    @elseif($existingRequest->status === 'approved')
                                        Your certificate request has been approved!
                                    @else
                                        Your certificate request was rejected.
                                    @endif
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('certificates.show', $existingRequest->id) }}" class="btn btn-primary">
                                        View Request Details
                                    </a>
                                </div>
                            @else
                                <form id="certificateRequestForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                                   value="{{ auth()->user()->name }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="{{ auth()->user()->email }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone" 
                                                   value="{{ auth()->user()->phone }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="image" class="form-label">Profile Image <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="image" name="image" 
                                                   accept="image/*" required>
                                            <div class="form-text">Please upload a clear photo of yourself (max 2MB)</div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ auth()->user()->address }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="city" name="city" 
                                                   value="{{ auth()->user()->city }}" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="state" name="state" 
                                                   value="{{ auth()->user()->state }}" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="country" name="country" 
                                                   value="{{ auth()->user()->country }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="zip_code" class="form-label">ZIP Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="zip_code" name="zip_code" 
                                                   value="{{ auth()->user()->zip_code }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <iconify-icon icon="solar:diploma-verified-outline" class="me-2"></iconify-icon>
                                            Submit Certificate Request
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showNotEligibleAlert() {
    Swal.fire({
        icon: 'warning',
        title: 'Not Eligible',
        text: 'You are not eligible for certificate yet. You need to be registered for at least 30 days.',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
}

$(document).ready(function() {
    $('#certificateRequestForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Show loading
        Swal.fire({
            title: 'Submitting Request...',
            text: 'Please wait while we process your certificate request.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        $.ajax({
            url: '{{ route("certificates.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("certificates.index") }}';
                    }
                });
            },
            error: function(xhr) {
                let message = 'An error occurred while submitting your request.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
</script>
@endpush
@endsection

