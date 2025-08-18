@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Expenses Management</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">All Expenses</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Today's Expenses</p>
                                <h4 class="mb-2">KES {{ number_format($todayTotal, 2) }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-money-bill-wave font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Month Total</p>
                                <h4 class="mb-2">KES {{ number_format($monthTotal, 2) }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-calendar-month font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Pending Approval</p>
                                <h4 class="mb-2">{{ $pendingCount }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-clock font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Quick Actions</p>
                                <a href="{{ route('expenses.create') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus me-1"></i> Add Expense
                                </a>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-plus-circle font-size-20"></i>
                                    </span>
                                </div>
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
                    <div class="card-body">
                        <form method="GET" action="{{ route('expenses.index') }}" class="row g-3">
                            <div class="col-md-3">
                                <label for="category" class="form-label">Category</label>
                                <select name="category" id="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control"
                                       value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control"
                                       value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">All Expenses</h4>
                            <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add New Expense
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Vendor</th>
                                        <th>Amount</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge rounded-pill" style="background-color: {{ $expense->category->color_code }}">
                                                <i class="{{ $expense->category->icon_class }} me-1"></i>
                                                {{ $expense->category->name }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($expense->description, 50) }}</td>
                                        <td>{{ $expense->vendor_name }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">KES {{ number_format($expense->amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $expense->payment_method }}</span>
                                        </td>
                                        <td>
                                            @if($expense->approval_status == 'Approved')
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($expense->approval_status == 'Pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-light btn-sm dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                                    Actions
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('expenses.show', $expense) }}">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a></li>
                                                    <li><a class="dropdown-item" href="{{ route('expenses.edit', $expense) }}">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a></li>
                                                    @if($expense->approval_status == 'Pending')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('expenses.approve', $expense) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="fas fa-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('expenses.reject', $expense) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item text-warning">
                                                                <i class="fas fa-times me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    <li><hr class="dropdown-divider"></li>
                                                    @if(Auth::user()->can('mpesa.compare'))
                                                    <li>
                                                        <button type="button" class="dropdown-item text-danger" 
                                                                onclick="confirmDeleteExpense({{ $expense->id }}, '{{ addslashes($expense->description) }}', '{{ $expense->vendor_name }}', 'KES {{ number_format($expense->amount, 2) }}')">
                                                            <i class="fas fa-trash me-1"></i> Delete
                                                        </button>
                                                    </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-receipt fa-3x mb-3 d-block"></i>
                                                <h5>No expenses found</h5>
                                                <p>Start by <a href="{{ route('expenses.create') }}">adding your first expense</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($expenses->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $expenses->appends(request()->query())->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Delete Confirmation Modal -->
<div class="modal fade" id="deleteExpenseModal" tabindex="-1" aria-labelledby="deleteExpenseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <div class="d-flex align-items-center">
                    <div class="modal-icon-wrapper me-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="deleteExpenseModalLabel">Confirm Expense Deletion</h5>
                        <p class="mb-0 small opacity-75">This action cannot be undone</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning border-0 bg-warning bg-opacity-10">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-warning fa-lg"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="alert-heading text-warning mb-1">Important Notice</h6>
                                    <p class="mb-0 small">You are about to permanently delete this expense record. This will:</p>
                                </div>
                            </div>
                        </div>
                        
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">
                                <i class="fas fa-times-circle text-danger me-2"></i>
                                <span>Remove the expense from all reports and analytics</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times-circle text-danger me-2"></i>
                                <span>Delete any associated receipt images</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-times-circle text-danger me-2"></i>
                                <span>Remove the transaction from the audit trail</span>
                            </li>
                        </ul>
                        
                        <div class="expense-details-card bg-light rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-receipt me-2"></i>Expense Details
                            </h6>
                            <div class="row g-2">
                                <div class="col-12">
                                    <strong>Description:</strong> 
                                    <span id="delete-expense-description" class="ms-2"></span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Vendor:</strong> 
                                    <span id="delete-expense-vendor" class="ms-2"></span>
                                </div>
                                <div class="col-sm-6">
                                    <strong>Amount:</strong> 
                                    <span id="delete-expense-amount" class="ms-2 text-primary fw-bold"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-muted small mb-0">
                                <i class="fas fa-shield-alt me-1"></i>
                                This action is logged for security purposes
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <form id="deleteExpenseForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Yes, Delete Expense
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteExpense(expenseId, description, vendor, amount) {
    // Update modal content with expense details
    document.getElementById('delete-expense-description').textContent = description;
    document.getElementById('delete-expense-vendor').textContent = vendor;
    document.getElementById('delete-expense-amount').textContent = amount;
    
    // Update form action with the correct route
    const form = document.getElementById('deleteExpenseForm');
    form.action = `{{ route('expenses.index') }}/${expenseId}`;
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('deleteExpenseModal'));
    modal.show();
}

// Enhanced form submission with loading state
document.getElementById('deleteExpenseForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Deleting...';
    submitBtn.disabled = true;
    
    // Add a slight delay to show the loading state
    setTimeout(() => {
        // Form will submit naturally after this
    }, 500);
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteExpenseModal'));
        if (modal) {
            modal.hide();
        }
    }
});
</script>

<style>
/* Enhanced Modal Styling */
.modal-icon-wrapper {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.expense-details-card {
    border-left: 4px solid #dc3545;
}

.modal-content {
    border-radius: 15px;
    overflow: hidden;
}

.modal-header {
    border-bottom: none;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
}

.modal-footer {
    border-top: 1px solid #dee2e6;
    background: #f8f9fa;
}

.alert-warning {
    border-left: 4px solid #ffc107;
}

/* Loading animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fa-spin {
    animation: spin 1s linear infinite;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .modal-dialog {
        margin: 1rem 0.5rem;
    }
    
    .modal-icon-wrapper {
        width: 50px;
        height: 50px;
    }
    
    .modal-icon-wrapper i {
        font-size: 1.5rem;
    }
}
</style>

@endsection
