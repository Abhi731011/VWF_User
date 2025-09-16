@extends('master.main')

@section('content')
<div class="dashboard-content-wrapper">
    <div class="dashboard-main-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header d-flex justify-content-between align-items-center">
                            <h4 class="dashboard-card-title">My Certificate Requests</h4>
                            <a href="{{ route('certificates.create') }}" class="btn btn-primary">
                                <iconify-icon icon="solar:add-circle-outline" class="me-2"></iconify-icon>
                                New Request
                            </a>
                        </div>
                        <div class="dashboard-card-body">
                            @if($requests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Request ID</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Submitted Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests as $request)
                                                <tr>
                                                    <td>#{{ $request->id }}</td>
                                                    <td>{{ $request->full_name }}</td>
                                                    <td>{{ $request->email }}</td>
                                                    <td>
                                                        @if($request->status === 'pending')
                                                            <span class="badge bg-warning">
                                                                <iconify-icon icon="solar:clock-circle-outline" class="me-1"></iconify-icon>
                                                                Pending
                                                            </span>
                                                        @elseif($request->status === 'approved')
                                                            <span class="badge bg-success">
                                                                <iconify-icon icon="solar:check-circle-outline" class="me-1"></iconify-icon>
                                                                Approved
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                <iconify-icon icon="solar:close-circle-outline" class="me-1"></iconify-icon>
                                                                Rejected
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $request->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('certificates.show', $request->id) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <iconify-icon icon="solar:eye-outline"></iconify-icon>
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <iconify-icon icon="solar:diploma-verified-outline" style="font-size: 4rem; color: #6c757d;"></iconify-icon>
                                    <h5 class="mt-3">No Certificate Requests</h5>
                                    <p class="text-muted">You haven't submitted any certificate requests yet.</p>
                                    <a href="{{ route('certificates.create') }}" class="btn btn-primary">
                                        <iconify-icon icon="solar:add-circle-outline" class="me-2"></iconify-icon>
                                        Submit Your First Request
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

