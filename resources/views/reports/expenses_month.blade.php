@extends('admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ $monthName }} - Expense Report</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reports.specific_report') }}">Reports</a></li>
                            <li class="breadcrumb-item active">Expenses Report</li>
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
                                <p class="text-truncate font-size-14 mb-2">Total Expenses</p>
                                <h4 class="mb-2">KES {{ number_format($totalExpenses, 2) }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-receipt font-size-20"></i>
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
                                <p class="text-truncate font-size-14 mb-2">Total Transactions</p>
                                <h4 class="mb-2">{{ number_format($totalCount) }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-hashtag font-size-20"></i>
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
                                <p class="text-truncate font-size-14 mb-2">Categories Used</p>
                                <h4 class="mb-2">{{ $categoryTotals->count() }}</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="avatar-sm rounded-circle bg-white bg-opacity-20 mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-transparent">
                                        <i class="fas fa-tags font-size-20"></i>
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
                                <p class="text-truncate font-size-14 mb-2">Avg Per Day</p>
                                <h4 class="mb-2">KES {{ number_format($totalExpenses / date('t', mktime(0, 0, 0, $month, 1, $year)), 2) }}</h4>
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
        </div>

        <!-- Action Buttons -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.expenses.downloadMonth', ['month' => $month, 'year' => $year]) }}" 
                       class="btn btn-success">
                        <i class="fas fa-download me-1"></i>Download CSV
                    </a>
                    <a href="{{ route('reports.specific_report') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Reports
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Expenses by Category
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($categoryTotals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Transactions</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryTotals->sortByDesc('total') as $categoryData)
                                    <tr>
                                        <td>
                                            <span class="badge rounded-pill" style="background-color: {{ $categoryData['category']->color_code }}">
                                                <i class="{{ $categoryData['category']->icon_class }} me-1"></i>
                                                {{ $categoryData['category']->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold">KES {{ number_format($categoryData['total'], 2) }}</span>
                                        </td>
                                        <td>{{ $categoryData['count'] }}</td>
                                        <td>
                                            @php
                                                $percentage = $totalExpenses > 0 ? ($categoryData['total'] / $totalExpenses) * 100 : 0;
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar" 
                                                         style="width: {{ $percentage }}%; background-color: {{ $categoryData['category']->color_code }};"></div>
                                                </div>
                                                <small class="text-muted">{{ number_format($percentage, 1) }}%</small>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No expenses recorded for this month</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Top Vendors -->
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-store me-2"></i>Top Vendors
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($topVendors->count() > 0)
                        @foreach($topVendors as $vendor)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">{{ Str::limit($vendor['vendor'], 20) }}</h6>
                                <small class="text-muted">{{ $vendor['count'] }} transactions</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-primary">KES {{ number_format($vendor['total'], 0) }}</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-store fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No vendors found</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Daily Breakdown Chart -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>Daily Spending
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($dailyBreakdown->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($dailyBreakdown->take(10) as $day)
                                    <tr>
                                        <td>{{ $day['date']->format('M j') }}</td>
                                        <td class="text-end">
                                            <span class="fw-bold">KES {{ number_format($day['total'], 0) }}</span>
                                            <br><small class="text-muted">{{ $day['count'] }} items</small>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">No daily data available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Expenses List -->
        @if($expenses->count() > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>All Expenses ({{ $totalCount }})
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Vendor</th>
                                        <th>Amount</th>
                                        <th>Payment</th>
                                        <th>Added By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->expense_date->format('M j') }}</td>
                                        <td>
                                            <span class="badge rounded-pill" style="background-color: {{ $expense->category->color_code }}">
                                                <i class="{{ $expense->category->icon_class }} me-1"></i>
                                                {{ $expense->category->name }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($expense->description, 40) }}</td>
                                        <td>{{ $expense->vendor_name }}</td>
                                        <td>
                                            <span class="fw-bold text-primary">KES {{ number_format($expense->amount, 2) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $expense->payment_method }}</span>
                                        </td>
                                        <td>{{ $expense->creator->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection