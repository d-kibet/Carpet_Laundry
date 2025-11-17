@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">SMS Statistics</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sms.dashboard') }}">SMS</a></li>
                            <li class="breadcrumb-item active">Statistics</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overview Statistics -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0">Total Sent</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['total_sent']) }}</span>
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
                                <p class="text-uppercase fw-medium text-muted mb-0">Total Failed</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['total_failed']) }}</span>
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
                                <p class="text-uppercase fw-medium text-muted mb-0">Success Rate</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                    <span class="counter-value">{{ number_format($stats['success_rate'], 1) }}</span>%
                                </h4>
                                <span class="badge badge-soft-info mb-0">Overall</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info rounded fs-3">
                                    <i class="bx bx-trending-up text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-animate bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-white-50 mb-0">SMS Balance</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-4">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-4 text-white">
                                    <span class="counter-value">{{ number_format($balance['balance'] ?? 0) }}</span>
                                </h4>
                                <span class="badge badge-soft-light mb-0">Credits</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-light rounded fs-3">
                                    <i class="bx bx-dollar-circle text-white"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Time-based Statistics -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs me-3">
                                <div class="avatar-title rounded bg-soft-primary text-primary fs-18">
                                    <i class="ri-calendar-todo-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-16 mb-1">{{ number_format($stats['today']) }}</h5>
                                <p class="text-muted mb-0">Today</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs me-3">
                                <div class="avatar-title rounded bg-soft-success text-success fs-18">
                                    <i class="ri-calendar-check-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-16 mb-1">{{ number_format($stats['yesterday']) }}</h5>
                                <p class="text-muted mb-0">Yesterday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs me-3">
                                <div class="avatar-title rounded bg-soft-info text-info fs-18">
                                    <i class="ri-calendar-event-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-16 mb-1">{{ number_format($stats['this_week']) }}</h5>
                                <p class="text-muted mb-0">This Week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar-xs me-3">
                                <div class="avatar-title rounded bg-soft-warning text-warning fs-18">
                                    <i class="ri-calendar-line"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fs-16 mb-1">{{ number_format($stats['this_month']) }}</h5>
                                <p class="text-muted mb-0">This Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Status Statistics -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-soft-primary border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">
                            <i class="ri-mail-check-line me-2"></i>Delivery Status Tracking
                        </h5>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <div class="avatar-xs me-3">
                                        <div class="avatar-title rounded bg-soft-success text-success fs-18">
                                            <i class="ri-check-double-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-1">{{ number_format($stats['delivered']) }}</h5>
                                        <p class="text-muted mb-0">Delivered</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <div class="avatar-xs me-3">
                                        <div class="avatar-title rounded bg-soft-info text-info fs-18">
                                            <i class="ri-send-plane-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-1">{{ number_format($stats['submitted']) }}</h5>
                                        <p class="text-muted mb-0">Submitted</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <div class="avatar-xs me-3">
                                        <div class="avatar-title rounded bg-soft-warning text-warning fs-18">
                                            <i class="ri-time-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-1">{{ number_format($stats['delivery_pending']) }}</h5>
                                        <p class="text-muted mb-0">Pending</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="d-flex align-items-center p-3 bg-white rounded">
                                    <div class="avatar-xs me-3">
                                        <div class="avatar-title rounded bg-soft-danger text-danger fs-18">
                                            <i class="ri-error-warning-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fs-16 mb-1">{{ number_format($stats['delivery_failed']) }}</h5>
                                        <p class="text-muted mb-0">Failed Delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <div class="p-3 bg-white rounded">
                                    <h4 class="mb-1 text-success">{{ number_format($stats['delivery_rate'], 1) }}%</h4>
                                    <p class="text-muted mb-0">Actual Delivery Rate</p>
                                    <small class="text-muted">(Messages delivered to recipients)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <!-- Last 30 Days Chart -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Last 30 Days Trend</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="smsChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- SMS by Delivery Status -->
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Delivery Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="deliveryStatusChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- SMS by Send Status -->
            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Send Status</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS by Type and Top Recipients -->
        <div class="row">
            <!-- SMS by Type -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">SMS by Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Count</th>
                                        <th class="text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($byType as $type)
                                    <tr>
                                        <td>
                                            <span class="badge
                                                @if($type->type == 'manual') badge-soft-info
                                                @elseif($type->type == 'automated') badge-soft-success
                                                @elseif($type->type == 'bulk') badge-soft-warning
                                                @else badge-soft-secondary
                                                @endif">
                                                {{ ucfirst($type->type) }}
                                            </span>
                                        </td>
                                        <td class="text-end fw-medium">{{ number_format($type->count) }}</td>
                                        <td class="text-end">
                                            <span class="badge badge-soft-primary">
                                                {{ number_format(($type->count / $stats['total_sms']) * 100, 1) }}%
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Recipients -->
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Top 10 Recipients</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Phone Number</th>
                                        <th class="text-end">SMS Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topRecipients as $index => $recipient)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <span class="badge badge-soft-primary">{{ $recipient->phone_number }}</span>
                                        </td>
                                        <td class="text-end fw-medium">{{ number_format($recipient->count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Recent SMS Activity</h4>
                        <a href="{{ route('sms.history') }}" class="btn btn-sm btn-primary">
                            View All <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Date/Time</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Sent By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentActivity as $log)
                                    <tr>
                                        <td>
                                            <span class="fw-medium">{{ $log->created_at->format('M d, Y') }}</span><br>
                                            <small class="text-muted">{{ $log->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary">{{ $log->phone_number }}</span>
                                        </td>
                                        <td>
                                            <div style="max-width: 250px;">
                                                {{ Str::limit($log->message, 50) }}
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
                                            <span class="badge badge-soft-danger">
                                                <i class="ri-close-line me-1"></i>Failed
                                            </span>
                                            @else
                                            <span class="badge badge-soft-warning">
                                                <i class="ri-time-line me-1"></i>Pending
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($log->user)
                                            {{ $log->user->name }}
                                            @else
                                            <span class="text-muted">System</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Last 30 Days Line Chart
const smsCtx = document.getElementById('smsChart').getContext('2d');
const smsChart = new Chart(smsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($last30Days, 'date')) !!},
        datasets: [
            {
                label: 'Total SMS',
                data: {!! json_encode(array_column($last30Days, 'count')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Sent',
                data: {!! json_encode(array_column($last30Days, 'sent')) !!},
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Failed',
                data: {!! json_encode(array_column($last30Days, 'failed')) !!},
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($byStatus->pluck('status')->map(fn($s) => ucfirst($s))->toArray()) !!},
        datasets: [{
            data: {!! json_encode($byStatus->pluck('count')->toArray()) !!},
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',   // success - green
                'rgba(239, 68, 68, 0.8)',   // failed - red
                'rgba(251, 191, 36, 0.8)',  // pending - yellow
            ],
            borderColor: [
                'rgb(34, 197, 94)',
                'rgb(239, 68, 68)',
                'rgb(251, 191, 36)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});

// Delivery Status Pie Chart
const deliveryStatusCtx = document.getElementById('deliveryStatusChart').getContext('2d');
const deliveryStatusChart = new Chart(deliveryStatusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($byDeliveryStatus->pluck('delivery_status')->map(fn($s) => ucfirst($s))->toArray()) !!},
        datasets: [{
            data: {!! json_encode($byDeliveryStatus->pluck('count')->toArray()) !!},
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',   // delivered - green
                'rgba(59, 130, 246, 0.8)',  // submitted - blue
                'rgba(251, 191, 36, 0.8)',  // pending - yellow
                'rgba(239, 68, 68, 0.8)',   // failed - red
                'rgba(249, 115, 22, 0.8)',  // undelivered - orange
                'rgba(168, 85, 247, 0.8)',  // rejected - purple
                'rgba(107, 114, 128, 0.8)', // expired - gray
            ],
            borderColor: [
                'rgb(34, 197, 94)',
                'rgb(59, 130, 246)',
                'rgb(251, 191, 36)',
                'rgb(239, 68, 68)',
                'rgb(249, 115, 22)',
                'rgb(168, 85, 247)',
                'rgb(107, 114, 128)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>

@endsection
