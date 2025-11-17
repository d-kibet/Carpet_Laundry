@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">SMS Dashboard</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">SMS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Row -->
        <div class="row">
            <!-- SMS Balance Card -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0 small">SMS Balance</p>
                            </div>
                            <div class="flex-shrink-0">
                                <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-refresh-line align-middle" id="refresh-balance"
                                       style="cursor: pointer;" title="Refresh Balance"></i>
                                </h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-3">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" id="sms-balance">{{ number_format($stats['balance'] ?? 0) }}</span>
                                </h4>
                                <span class="badge badge-soft-success">Credits</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-success rounded fs-3">
                                    <i class="bx bx-dollar-circle text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0 small">Total Customers</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-3">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value">{{ number_format($stats['total_customers'] ?? 0) }}</span>
                                </h4>
                                <span class="badge badge-soft-primary">Active</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-primary rounded fs-3">
                                    <i class="bx bx-group text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Templates Available Card -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-muted mb-0 small">Templates</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-3">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value">{{ $stats['templates'] ?? 0 }}</span>
                                </h4>
                                <span class="badge badge-soft-info">Ready to use</span>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-soft-info rounded fs-3">
                                    <i class="bx bx-message-square-detail text-info"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Card -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                <div class="card card-animate bg-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <p class="text-uppercase fw-medium text-white-50 mb-0 small">Quick Actions</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-3">
                            <div class="w-100">
                                <a href="{{ route('sms.send') }}" class="btn btn-light btn-sm mb-2 w-100">
                                    <i class="mdi mdi-send me-1"></i> Send SMS
                                </a>
                                <a href="{{ route('sms.bulk') }}" class="btn btn-outline-light btn-sm w-100">
                                    <i class="mdi mdi-send-circle me-1"></i> Bulk SMS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SMS Management Links Row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="ri-apps-line me-2"></i>SMS Management
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Send Single SMS -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('sms.send') }}" class="text-reset text-decoration-none">
                                    <div class="p-3 border border-dashed rounded hover-card">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <div class="avatar-title rounded bg-soft-success text-success fs-18">
                                                    <i class="ri-send-plane-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-14 mb-1">Send Single SMS</h5>
                                                <p class="text-muted mb-0 fs-12 text-truncate">Send to one customer</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Bulk SMS -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('sms.bulk') }}" class="text-reset text-decoration-none">
                                    <div class="p-3 border border-dashed rounded hover-card">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <div class="avatar-title rounded bg-soft-primary text-primary fs-18">
                                                    <i class="ri-send-plane-fill"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-14 mb-1">Bulk SMS</h5>
                                                <p class="text-muted mb-0 fs-12 text-truncate">Send to multiple customers</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- SMS History -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('sms.history') }}" class="text-reset text-decoration-none">
                                    <div class="p-3 border border-dashed rounded hover-card">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <div class="avatar-title rounded bg-soft-info text-info fs-18">
                                                    <i class="ri-history-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-14 mb-1">SMS History</h5>
                                                <p class="text-muted mb-0 fs-12 text-truncate">View sent messages</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Statistics -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <a href="{{ route('sms.statistics') }}" class="text-reset text-decoration-none">
                                    <div class="p-3 border border-dashed rounded hover-card">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <div class="avatar-title rounded bg-soft-warning text-warning fs-18">
                                                    <i class="ri-bar-chart-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="fs-14 mb-1">Statistics</h5>
                                                <p class="text-muted mb-0 fs-12 text-truncate">View SMS analytics</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Templates Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="ri-message-2-line me-2"></i>Available Message Templates
                        </h4>
                        <button class="btn btn-sm btn-soft-primary" type="button"
                                data-bs-toggle="collapse" data-bs-target="#templatesCollapse"
                                aria-expanded="true" aria-controls="templatesCollapse">
                            <i class="ri-eye-line me-1"></i> Toggle Templates
                        </button>
                    </div>
                    <div class="collapse show" id="templatesCollapse">
                        <div class="card-body">
                            <div class="accordion" id="templatesAccordion">
                                @php
                                    $templates = config('sms.templates');
                                    $index = 0;
                                @endphp

                                @foreach($templates as $key => $template)
                                <div class="accordion-item border mb-2">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                aria-controls="collapse{{ $index }}">
                                            <i class="ri-message-2-line me-2"></i>
                                            <strong>{{ ucwords(str_replace('_', ' ', $key)) }}</strong>
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}"
                                         class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                         aria-labelledby="heading{{ $index }}"
                                         data-bs-parent="#templatesAccordion">
                                        <div class="accordion-body">
                                            <div class="bg-light p-3 rounded mb-3">
                                                <p class="mb-0 text-dark">{{ $template }}</p>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted fw-medium">
                                                    <i class="ri-code-line me-1"></i>Available Variables:
                                                </small>
                                                <div class="mt-2">
                                                    @php
                                                        preg_match_all('/:(\w+)/', $template, $matches);
                                                        $variables = $matches[1];
                                                    @endphp
                                                    @foreach($variables as $var)
                                                        <span class="badge badge-soft-info me-1 mb-1">:{{ $var }}</span>
                                                    @endforeach
                                                    @if(empty($variables))
                                                        <span class="text-muted fst-italic">No variables</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $index++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Custom Styles for Mobile Responsiveness and Hover Effects -->
<style>
/* Hover effect for management cards */
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    background-color: #f8f9fa;
    border-color: #0d6efd !important;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    transform: translateY(-2px);
}

/* Card animations */
.card-animate {
    transition: all 0.3s ease;
}

.card-animate:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .page-title-box h4 {
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .fs-22 {
        font-size: 1.25rem !important;
    }

    .avatar-sm {
        display: none;
    }
}

@media (max-width: 576px) {
    .col-sm-6 {
        width: 100%;
    }

    .page-title-right {
        display: none;
    }

    .card-title {
        font-size: 1rem;
    }
}

/* Accordion improvements */
.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #0d6efd;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0, 0, 0, 0.125);
}

/* Ensure proper spacing at bottom for footer */
.page-content {
    padding-bottom: 2rem;
    min-height: calc(100vh - 140px);
}

/* Loading spinner for refresh */
.spin-refresh {
    animation: spin-animation 1s linear infinite;
}

@keyframes spin-animation {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<!-- JavaScript for Balance Refresh -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const refreshBtn = document.getElementById('refresh-balance');
    const balanceEl = document.getElementById('sms-balance');

    if (refreshBtn && balanceEl) {
        refreshBtn.addEventListener('click', function() {
            // Add spinning animation
            this.classList.add('spin-refresh');

            fetch('{{ route("sms.balance") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        balanceEl.textContent = data.balance.toLocaleString();

                        // Show success feedback
                        toastr.success('Balance updated successfully!', 'Success', {
                            timeOut: 2000,
                            progressBar: true
                        });
                    } else {
                        toastr.error('Failed to refresh balance', 'Error');
                    }
                })
                .catch(error => {
                    console.error('Error refreshing balance:', error);
                    toastr.error('Failed to refresh balance', 'Error');
                })
                .finally(() => {
                    // Remove spinning animation
                    setTimeout(() => {
                        refreshBtn.classList.remove('spin-refresh');
                    }, 500);
                });
        });
    }
});
</script>

@endsection
