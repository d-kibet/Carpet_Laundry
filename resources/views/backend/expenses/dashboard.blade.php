@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Expense Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Expense Dashboard</li>
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
                                <p class="text-truncate font-size-13 mb-0">
                                    <span class="text-white-50">{{ $todayCount }} transactions</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-calendar-day font-size-20"></i>
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
                                <p class="text-truncate font-size-14 mb-2">This Month</p>
                                <h4 class="mb-2">KES {{ number_format($monthTotal, 2) }}</h4>
                                <p class="text-truncate font-size-13 mb-0">
                                    <span class="text-white-50">Monthly spending</span>
                                </p>
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
                                <p class="text-truncate font-size-13 mb-0">
                                    <span class="text-white-50">Awaiting review</span>
                                </p>
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
                                <div class="d-flex gap-1">
                                    <a href="{{ route('expenses.create') }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                    <a href="{{ route('expenses.index') }}" class="btn btn-light btn-sm">
                                        <i class="fas fa-list"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-bolt font-size-20"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Breakdown and Recent Expenses -->
        <div class="row">
            <!-- Category Breakdown -->
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Category Breakdown (This Month)
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($categoryBreakdown as $category)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="border rounded p-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="flex-shrink-0">
                                            <div class="avatar-sm">
                                                <span class="avatar-title rounded-circle" style="background-color: {{ $category['color'] }}20; color: {{ $category['color'] }}">
                                                    <i class="{{ $category['icon'] }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $category['name'] }}</h6>
                                            <p class="text-muted mb-0">KES {{ number_format($category['amount'], 2) }}</p>
                                        </div>
                                    </div>
                                    
                                    <small class="text-muted">This month's total</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Expenses -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Recent Expenses
                        </h4>
                    </div>
                    <div class="card-body">
                        @forelse($recentExpenses as $expense)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle" style="background-color: {{ $expense->category->color_code }}20; color: {{ $expense->category->color_code }}">
                                        <i class="{{ $expense->category->icon_class }}"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ Str::limit($expense->description, 30) }}</h6>
                                <p class="text-muted mb-0">
                                    <small>{{ $expense->vendor_name }} • {{ $expense->expense_date->format('M d') }}</small>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="text-primary fw-bold">KES {{ number_format($expense->amount, 0) }}</span>
                                @if($expense->approval_status == 'Pending')
                                <br><span class="badge bg-warning btn-sm">Pending</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No expenses yet</h6>
                            <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Add First Expense
                            </a>
                        </div>
                        @endforelse

                        @if($recentExpenses->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('expenses.index') }}" class="btn btn-outline-primary btn-sm">
                                View All Expenses
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Add Form -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-zap me-2"></i>Quick Add Expense
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="quick-expense-form">
                            @csrf
                            <div class="mb-3">
                                <select name="category_id" class="form-select form-select-sm" required>
                                    <option value="">Select Category</option>
                                    @foreach($categoryBreakdown as $category)
                                        <option value="{{ $loop->index + 1 }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text">KES</span>
                                    <input type="number" name="amount" class="form-control form-control-sm" 
                                           placeholder="Amount" step="0.01" min="0.01" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="description" class="form-control form-control-sm" 
                                       placeholder="What was this for?" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="vendor_name" class="form-control form-control-sm" 
                                       placeholder="Vendor (optional)">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-plus me-1"></i>Add Expense
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickForm = document.getElementById('quick-expense-form');
    
    quickForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('{{ route("expenses.quickAdd") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
                
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
                
                // Reset form
                quickForm.reset();
                
                // Optionally reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Something went wrong');
            }
        })
        .catch(error => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            
            Toast.fire({
                icon: 'error',
                title: error.message || 'Error adding expense'
            });
        });
    });
});
</script>

@endsection