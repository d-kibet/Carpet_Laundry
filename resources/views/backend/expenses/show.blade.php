@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Expense Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">Expenses</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle" style="background-color: {{ $expense->category->color_code }}; color: white;">
                                        <i class="{{ $expense->category->icon_class }}"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">{{ $expense->description }}</h5>
                                <p class="card-title-desc mb-0">
                                    <span class="badge rounded-pill" style="background-color: {{ $expense->category->color_code }}">
                                        {{ $expense->category->name }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                @if($expense->approval_status == 'Approved')
                                    <span class="badge bg-success fs-6">Approved</span>
                                @elseif($expense->approval_status == 'Pending')
                                    <span class="badge bg-warning fs-6">Pending</span>
                                @else
                                    <span class="badge bg-danger fs-6">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Amount</label>
                                    <p class="text-primary fs-4 fw-bold mb-0">KES {{ number_format($expense->amount, 2) }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Expense Date</label>
                                    <p class="mb-0">{{ $expense->expense_date->format('F j, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Vendor/Supplier</label>
                                    <p class="mb-0">{{ $expense->vendor_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Payment Method</label>
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">{{ $expense->payment_method }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($expense->transaction_reference)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Transaction Reference</label>
                                    <p class="mb-0 font-monospace">{{ $expense->transaction_reference }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($expense->notes)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Additional Notes</label>
                                    <p class="mb-0">{{ $expense->notes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Receipt Image -->
                        @if($expense->receipt_image)
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Receipt</label>
                                    <div class="mt-2">
                                        @if($expense->hasValidReceipt())
                                            <div class="receipt-container">
                                                <img src="{{ $expense->receipt_url }}"
                                                     alt="Receipt"
                                                     class="img-thumbnail"
                                                     style="max-height: 300px; cursor: pointer; border: 2px solid #ddd;"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#receiptModal"
                                                     loading="lazy"
                                                     onerror="showImageError(this)">
                                            </div>
                                        @else
                                            <div class="alert alert-warning d-flex align-items-center">
                                                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                                <div>
                                                    <strong>Receipt file not found</strong><br>
                                                    <small class="text-muted">File path: {{ $expense->receipt_image }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Receipt</label>
                                    <div class="mt-2">
                                        <div class="text-muted d-flex align-items-center">
                                            <i class="fas fa-receipt fa-2x me-3 text-secondary"></i>
                                            <span>No receipt uploaded for this expense</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i>Edit Expense
                                    </a>

                                    @if($expense->approval_status == 'Pending')
                                    <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-1"></i>Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-times me-1"></i>Reject
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Back to List
                                    </a>

                                    @if(Auth::user()->can('mpesa.compare'))
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Are you sure you want to delete this expense?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Expense Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Created By</td>
                                        <td>{{ $expense->creator->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Created Date</td>
                                        <td>{{ $expense->created_at->format('M j, Y g:i A') }}</td>
                                    </tr>
                                    @if($expense->approver)
                                    <tr>
                                        <td class="fw-bold">Approved By</td>
                                        <td>{{ $expense->approver->name }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-bold">Last Updated</td>
                                        <td>{{ $expense->updated_at->format('M j, Y g:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Category Budget Info -->
                @if($expense->category->budget_limit)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>Category Budget
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $currentMonthSpent = $expense->category->getCurrentMonthExpenses();
                            $budgetUsed = $expense->category->getBudgetUsagePercentage();
                            $remaining = $expense->category->budget_limit - $currentMonthSpent;
                        @endphp

                        <div class="text-center mb-3">
                            <h4 class="text-primary">{{ number_format($budgetUsed, 1) }}%</h4>
                            <p class="text-muted mb-0">Budget Used This Month</p>
                        </div>

                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar {{ $budgetUsed > 90 ? 'bg-danger' : ($budgetUsed > 70 ? 'bg-warning' : 'bg-success') }}"
                                 role="progressbar"
                                 style="width: {{ min(100, $budgetUsed) }}%">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="text-center">
                                <h6 class="mb-0">KES {{ number_format($currentMonthSpent, 0) }}</h6>
                                <small class="text-muted">Spent</small>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0">KES {{ number_format($remaining, 0) }}</h6>
                                <small class="text-muted">Remaining</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
@if($expense->receipt_image)
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Receipt Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                @if($expense->hasValidReceipt())
                    <img src="{{ $expense->receipt_url }}"
                         alt="Receipt"
                         class="img-fluid"
                         loading="lazy"
                         onerror="showImageError(this, 'modal')">
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Receipt image could not be loaded
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if($expense->hasValidReceipt())
                    <a href="{{ $expense->receipt_url }}"
                       class="btn btn-primary"
                       download="receipt-{{ $expense->id }}-{{ date('Y-m-d') }}.{{ pathinfo($expense->receipt_image, PATHINFO_EXTENSION) }}"
                       target="_blank">
                        <i class="fas fa-download me-1"></i>Download Receipt
                    </a>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<script>
/**
 * Handle image loading errors with secure fallback
 * @param {HTMLElement} img - The image element that failed to load
 * @param {string} context - Context identifier ('modal' or 'thumbnail')
 */
function showImageError(img, context = 'thumbnail') {
    // Prevent further error events
    img.onerror = null;
    
    // Create error message container
    const errorContainer = document.createElement('div');
    errorContainer.className = 'alert alert-danger d-flex align-items-center';
    errorContainer.innerHTML = `
        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
        <div>
            <strong>Image Loading Error</strong><br>
            <small class="text-muted">Receipt image could not be displayed</small>
        </div>
    `;
    
    // Replace image with error message
    img.parentNode.replaceChild(errorContainer, img);
    
    // Log error for debugging (avoid exposing sensitive information)
    console.warn('Image loading failed for expense receipt');
}

/**
 * Validate file before upload (client-side security check)
 * @param {HTMLElement} input - File input element
 */
function validateReceiptFile(input) {
    const file = input.files[0];
    if (!file) return true;
    
    // Check file size (max 2MB)
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    if (file.size > maxSize) {
        alert('File size must be less than 2MB');
        input.value = '';
        return false;
    }
    
    // Check file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        alert('Only JPEG, PNG, and WebP images are allowed');
        input.value = '';
        return false;
    }
    
    return true;
}

// Add event listeners for file inputs if they exist
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"][name="receipt_image"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            validateReceiptFile(this);
        });
    });
});
</script>

@endsection
