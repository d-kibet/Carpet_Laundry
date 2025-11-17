@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">SMS History</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sms.dashboard') }}">SMS</a></li>
                            <li class="breadcrumb-item active">History</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0">Total SMS</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['total']) }}</span>
                                </h4>
                                <span class="badge badge-soft-info mb-0">All Time</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info rounded fs-3">
                                    <i class="bx bx-message-detail text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0">Sent Successfully</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['sent']) }}</span>
                                </h4>
                                <span class="badge badge-soft-success mb-0">Success</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-success rounded fs-3">
                                    <i class="bx bx-check-circle text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0">Failed</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['failed']) }}</span>
                                </h4>
                                <span class="badge badge-soft-danger mb-0">Error</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-danger rounded fs-3">
                                    <i class="bx bx-error-circle text-danger"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0">This Month</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['this_month']) }}</span>
                                </h4>
                                <span class="badge badge-soft-primary mb-0">{{ date('F') }}</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                    <i class="bx bx-calendar text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Filter SMS</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('sms.history') }}">
                            <div class="row g-3">
                                <div class="col-lg-2">
                                    <label class="form-label">Send Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Delivery Status</label>
                                    <select name="delivery_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="delivered" {{ request('delivery_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="submitted" {{ request('delivery_status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="pending" {{ request('delivery_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ request('delivery_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="undelivered" {{ request('delivery_status') == 'undelivered' ? 'selected' : '' }}>Undelivered</option>
                                        <option value="rejected" {{ request('delivery_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="expired" {{ request('delivery_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Type</label>
                                    <select name="type" class="form-select">
                                        <option value="">All Types</option>
                                        <option value="manual" {{ request('type') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automated" {{ request('type') == 'automated' ? 'selected' : '' }}>Automated</option>
                                        <option value="bulk" {{ request('type') == 'bulk' ? 'selected' : '' }}>Bulk</option>
                                        <option value="scheduled" {{ request('type') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">From Date</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">To Date</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="ri-filter-3-line me-1"></i> Filter
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-lg-10">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="Search by phone number or message..."
                                           value="{{ request('search') }}">
                                </div>
                                <div class="col-lg-2">
                                    <a href="{{ route('sms.history') }}" class="btn btn-secondary w-100">
                                        <i class="ri-refresh-line me-1"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS History Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">SMS Records ({{ $smsLogs->total() }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date/Time</th>
                                        <th>Phone Number</th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Send Status</th>
                                        <th>Delivery Status</th>
                                        <th>Sent By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($smsLogs as $index => $log)
                                    <tr>
                                        <td>{{ $smsLogs->firstItem() + $index }}</td>
                                        <td>
                                            <span class="fw-medium">{{ $log->created_at->format('M d, Y') }}</span><br>
                                            <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary">{{ $log->phone_number }}</span>
                                        </td>
                                        <td>
                                            <div style="max-width: 300px;">
                                                {{ Str::limit($log->message, 100) }}
                                                @if(strlen($log->message) > 100)
                                                <a href="#" class="text-primary" data-bs-toggle="tooltip"
                                                   title="{{ $log->message }}">
                                                    <i class="ri-information-line"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge
                                                @if($log->type == 'manual') badge-soft-info
                                                @elseif($log->type == 'automated') badge-soft-success
                                                @elseif($log->type == 'bulk') badge-soft-warning
                                                @else badge-soft-secondary
                                                @endif">
                                                {{ ucfirst($log->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($log->status == 'sent')
                                            <span class="badge badge-soft-success">
                                                <i class="ri-check-line me-1"></i>Sent
                                            </span>
                                            @elseif($log->status == 'failed')
                                            <span class="badge badge-soft-danger" data-bs-toggle="tooltip"
                                                  title="{{ $log->error_message }}">
                                                <i class="ri-close-line me-1"></i>Failed
                                            </span>
                                            @else
                                            <span class="badge badge-soft-warning">
                                                <i class="ri-time-line me-1"></i>Pending
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $deliveryStatus = $log->delivery_status ?? 'pending';
                                                $badgeClass = 'badge-soft-secondary';
                                                $icon = 'ri-question-line';

                                                if ($deliveryStatus == 'delivered') {
                                                    $badgeClass = 'badge-soft-success';
                                                    $icon = 'ri-check-double-line';
                                                } elseif ($deliveryStatus == 'submitted') {
                                                    $badgeClass = 'badge-soft-info';
                                                    $icon = 'ri-send-plane-line';
                                                } elseif (in_array($deliveryStatus, ['failed', 'undelivered', 'rejected', 'expired'])) {
                                                    $badgeClass = 'badge-soft-danger';
                                                    $icon = 'ri-error-warning-line';
                                                } elseif ($deliveryStatus == 'pending') {
                                                    $badgeClass = 'badge-soft-warning';
                                                    $icon = 'ri-time-line';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}"
                                                  @if($log->network_status)
                                                      data-bs-toggle="tooltip"
                                                      title="Network Code: {{ $log->network_status }}"
                                                  @endif>
                                                <i class="{{ $icon }} me-1"></i>{{ ucfirst($deliveryStatus) }}
                                            </span>
                                            @if($log->delivered_at)
                                            <br><small class="text-muted">{{ $log->delivered_at->format('M d, h:i A') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->user)
                                            <span class="text-muted">{{ $log->user->name }}</span>
                                            @else
                                            <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="ri-inbox-line fs-1 d-block mb-2"></i>
                                                No SMS records found
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                Showing {{ $smsLogs->firstItem() ?? 0 }} to {{ $smsLogs->lastItem() ?? 0 }}
                                of {{ $smsLogs->total() }} entries
                            </div>
                            <div>
                                {{ $smsLogs->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>

@endsection
