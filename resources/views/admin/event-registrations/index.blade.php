@extends('master.main')

@section('content')
<div class="admin-event-registrations-main-body">
    <!-- Header Section -->
    <div class="welcome-section mb-24">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold text-primary mb-2">Event Registrations Management</h3>
                <p class="text-secondary-light mb-0">Manage and review all event registrations.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex gap-2 justify-content-lg-end">
                    <button class="btn btn-outline-primary" onclick="exportRegistrations()">
                        <iconify-icon icon="solar:export-outline" class="me-2"></iconify-icon>
                        Export
                    </button>
                </div>
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

    <!-- Filter Form -->
    <div class="card shadow-sm border-0 mb-24">
        <div class="card-header bg-light">
            <h5 class="mb-0 fw-semibold">Filter Registrations</h5>
        </div>
        <div class="card-body p-24">
            <form method="GET" action="{{ route('admin.event-registrations.index') }}" class="filter-form">
                <div class="row g-3">
                    <!-- First Row -->
                    <div class="col-lg-3 col-md-6">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label for="event_id" class="form-label fw-semibold">Event</label>
                        <select class="form-select" id="event_id" name="event_id">
                            <option value="">All Events</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label for="date_from" class="form-label fw-semibold">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label for="date_to" class="form-label fw-semibold">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    
                    <!-- Second Row -->
                    <div class="col-lg-3 col-md-6">
                        <label for="search" class="form-label fw-semibold">Search</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Name, Email, Phone..." value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label for="sort_by" class="form-label fw-semibold">Sort By</label>
                        <select class="form-select" id="sort_by" name="sort_by">
                            <option value="registered_at" {{ request('sort_by') == 'registered_at' ? 'selected' : '' }}>Registration Date</option>
                            <option value="full_name" {{ request('sort_by') == 'full_name' ? 'selected' : '' }}>Name</option>
                            <option value="event_date" {{ request('sort_by') == 'event_date' ? 'selected' : '' }}>Event Date</option>
                            <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <label for="sort_order" class="form-label fw-semibold">Order</label>
                        <select class="form-select" id="sort_order" name="sort_order">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                    
                    <!-- Filter Buttons - Aligned with second row -->
                    <div class="col-lg-3 col-md-6 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <iconify-icon icon="solar:filter-outline" class="me-1"></iconify-icon>
                                Apply Filter
                            </button>
                            <a href="{{ route('admin.event-registrations.index') }}" class="btn btn-outline-secondary flex-fill">
                                <iconify-icon icon="solar:refresh-outline" class="me-1"></iconify-icon>
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Registration Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">Registrations ({{ $registrations->total() }})</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per page</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                </select>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">ID</th>
                            <th class="border-0">Event</th>
                            <th class="border-0">Participant</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0">Registration Date</th>
                            <th class="border-0">Status</th>
                            <th class="border-0 text-center" style="min-width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td class="align-middle">
                                    <span class="fw-semibold text-primary">#{{ $registration->id }}</span>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        @if($registration->event->banners && count($registration->event->banners) > 0)
                                            <img src="http://localhost/ngo/public/{{ $registration->event->banners[0] }}" 
                                                 class="event-thumbnail me-3" alt="{{ $registration->event->title }}">
                                        @else
                                            <div class="event-thumbnail-placeholder me-3 d-flex align-items-center justify-content-center">
                                                <iconify-icon icon="solar:calendar-outline" class="text-muted"></iconify-icon>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $registration->event->title }}</div>
                                            <div class="text-secondary-light small">{{ $registration->event->event_date->format('M j, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $registration->full_name }}</div>
                                        <div class="text-secondary-light small">{{ $registration->email }}</div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div>
                                        <div class="text-dark">{{ $registration->phone }}</div>
                                        @if($registration->emergency_contact_name)
                                            <div class="text-secondary-light small">
                                                Emergency: {{ $registration->emergency_contact_name }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="text-dark">{{ $registration->registered_at->format('M j, Y') }}</div>
                                    <div class="text-secondary-light small">{{ $registration->registered_at->format('g:i A') }}</div>
                                </td>
                                <td class="align-middle">
                                    @if($registration->status === 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                            Pending
                                        </span>
                                    @elseif($registration->status === 'approved')
                                        <span class="badge bg-success text-white">
                                            <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                            Approved
                                        </span>
                                    @elseif($registration->status === 'rejected')
                                        <span class="badge bg-danger text-white">
                                            <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                            Rejected
                                        </span>
                                    @elseif($registration->status === 'cancelled')
                                        <span class="badge bg-secondary text-white">
                                            <iconify-icon icon="solar:minus-circle-outline" class="me-1"></iconify-icon>
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="viewRegistration({{ $registration->id }})" 
                                                title="View Details">
                                            <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                        </button>
                                        
                                        <!-- Approve Button -->
                                        @if($registration->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-outline-success" 
                                                    onclick="updateStatus({{ $registration->id }}, 'approved')" 
                                                    title="Approve">
                                                <iconify-icon icon="solar:check-circle-outline"></iconify-icon>
                                            </button>
                                        @endif
                                        
                                        <!-- Reject Button -->
                                        @if($registration->status === 'pending')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="updateStatus({{ $registration->id }}, 'rejected')" 
                                                    title="Reject">
                                                <iconify-icon icon="solar:close-circle-outline"></iconify-icon>
                                            </button>
                                        @endif
                                        
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-outline-warning" 
                                                onclick="editRegistration({{ $registration->id }})" 
                                                title="Edit">
                                            <iconify-icon icon="solar:pen-outline"></iconify-icon>
                                        </button>
                                        
                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="deleteRegistration({{ $registration->id }})" 
                                                title="Delete">
                                            <iconify-icon icon="solar:trash-bin-outline"></iconify-icon>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <iconify-icon icon="solar:clipboard-remove-outline" class="text-muted mb-3" style="font-size: 3rem;"></iconify-icon>
                                    <h5 class="text-muted mb-2">No Registrations Found</h5>
                                    <p class="text-secondary-light">No event registrations match your current filters.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($registrations->hasPages())
            <div class="card-footer bg-light">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-secondary-light">
                        Showing {{ $registrations->firstItem() }} to {{ $registrations->lastItem() }} of {{ $registrations->total() }} results
                    </div>
                    <div>
                        {{ $registrations->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Registration Details Modal -->
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registrationModalLabel">Registration Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="registrationModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive Action Buttons */
.d-flex.gap-1 {
    gap: 0.25rem !important;
}

.d-flex.gap-1 .btn {
    min-width: 32px;
    height: 32px;
    padding: 0.375rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

/* Ensure buttons stay in one row on all screen sizes */
.d-flex.gap-1 {
    flex-wrap: nowrap !important;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* Hide scrollbar but keep functionality */
.d-flex.gap-1::-webkit-scrollbar {
    display: none;
}

.d-flex.gap-1 {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

/* Event thumbnail styles */
.event-thumbnail {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border-radius: 6px;
}

.event-thumbnail-placeholder {
    width: 40px;
    height: 40px;
    background-color: #f8f9fa;
    border-radius: 6px;
    font-size: 1.2rem;
}

/* Filter form responsive adjustments */
@media (max-width: 768px) {
    .filter-form .col-lg-3 {
        margin-bottom: 1rem;
    }
    
    .d-flex.gap-2.w-100 {
        flex-direction: column;
    }
    
    .d-flex.gap-2.w-100 .btn {
        width: 100% !important;
        margin-bottom: 0.5rem;
    }
}

/* Table responsive adjustments */
@media (max-width: 1200px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .d-flex.gap-1 .btn {
        min-width: 28px;
        height: 28px;
        padding: 0.25rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .d-flex.gap-1 .btn {
        min-width: 24px;
        height: 24px;
        padding: 0.2rem;
        font-size: 0.7rem;
    }
    
    .event-thumbnail,
    .event-thumbnail-placeholder {
        width: 32px;
        height: 32px;
    }
}

/* Ensure action column has minimum width */
th:last-child,
td:last-child {
    min-width: 180px !important;
    white-space: nowrap;
}
</style>

<script>
function viewRegistration(id) {
    // Load registration details via AJAX
    fetch(`/admin/event-registrations/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('registrationModalBody').innerHTML = html;
            new bootstrap.Modal(document.getElementById('registrationModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading registration details');
        });
}

function updateStatus(id, status) {
    if (confirm(`Are you sure you want to ${status} this registration?`)) {
        fetch(`/admin/event-registrations/${id}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status');
        });
    }
}

function editRegistration(id) {
    window.location.href = `/admin/event-registrations/${id}/edit`;
}

function deleteRegistration(id) {
    if (confirm('Are you sure you want to delete this registration? This action cannot be undone.')) {
        fetch(`/admin/event-registrations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting registration');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting registration');
        });
    }
}

function changePerPage(perPage) {
    const url = new URL(window.location);
    url.searchParams.set('per_page', perPage);
    window.location.href = url.toString();
}

function exportRegistrations() {
    const url = new URL(window.location);
    url.searchParams.set('export', '1');
    window.open(url.toString(), '_blank');
}
</script>
@endsection
