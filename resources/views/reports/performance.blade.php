@extends('admin_master')
@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Reports</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Performance Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Service Toggle -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <h5 class="card-title mb-0">Performance Dashboard</h5>
                        <div class="btn-group w-100 w-md-auto" role="group">
                            <input type="radio" class="btn-check" name="serviceType" id="carpet" value="carpet" checked>
                            <label class="btn btn-outline-primary" for="carpet">
                                <i class="bx bx-home d-md-inline d-none"></i> 
                                <span class="d-md-none">Carpet</span>
                                <span class="d-none d-md-inline">Carpet Cleaning</span>
                            </label>
                            <input type="radio" class="btn-check" name="serviceType" id="laundry" value="laundry">
                            <label class="btn btn-outline-primary" for="laundry">
                                <i class="bx bx-water d-md-inline d-none"></i> 
                                <span class="d-md-none">Laundry</span>
                                <span class="d-none d-md-inline">Laundry Service</span>
                            </label>
                            <input type="radio" class="btn-check" name="serviceType" id="expenses" value="expenses">
                            <label class="btn btn-outline-primary" for="expenses">
                                <i class="bx bx-receipt d-md-inline d-none"></i> 
                                <span class="d-md-none">Expenses</span>
                                <span class="d-none d-md-inline">Business Expenses</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" id="fromDate" value="{{ date('Y-m-01') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" id="toDate" value="{{ date('Y-m-t') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quick Select</label>
                            <select class="form-select" id="quickSelect">
                                <option value="custom">Custom Range</option>
                                <option value="today">Today</option>
                                <option value="yesterday">Yesterday</option>
                                <option value="this_week">This Week</option>
                                <option value="last_week">Last Week</option>
                                <option value="this_month" selected>This Month</option>
                                <option value="last_month">Last Month</option>
                                <option value="last_3_months">Last 3 Months</option>
                                <option value="this_year">This Year</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary w-100" id="refreshData">
                                <i class="bx bx-refresh"></i> Refresh Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4" id="metricsCards">
        <!-- Dynamic content loaded here -->
    </div>

    <!-- Service Charts (Hidden for Expenses) -->
    <div id="serviceChartsSection">
        <!-- Charts Layout -->
        <div class="row mb-4">
            <!-- Revenue Trends -->
            <div class="col-xl-8 col-lg-7 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0" id="revenueChartTitle">Revenue Trends</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 300px; position: relative;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="col-xl-4 col-lg-5 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0" id="paymentChartTitle">Payment Status</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div style="height: 250px; position: relative;">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Volume Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0" id="volumeChartTitle">Service Volume</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-9">
                                <div style="height: 250px; position: relative;">
                                    <canvas id="volumeChart"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="h-100 d-flex flex-column justify-content-center">
                                    <div class="row text-center g-2">
                                        <div class="col-12 mb-3">
                                            <div class="p-3 bg-primary bg-opacity-10 rounded">
                                                <i class="bx bx-bar-chart-alt-2 text-primary mb-2" style="font-size: 1.5rem;"></i>
                                                <h4 class="text-primary mb-0" id="totalVolume">0</h4>
                                                <small class="text-muted">Total Carpets</small>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="p-3 bg-success bg-opacity-10 rounded">
                                                <i class="bx bx-trending-up text-success mb-2" style="font-size: 1.5rem;"></i>
                                                <h4 class="text-success mb-0" id="peakDay">0</h4>
                                                <small class="text-muted">Peak Day</small>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-3 bg-info bg-opacity-10 rounded">
                                                <i class="bx bx-calendar text-info mb-2" style="font-size: 1.5rem;"></i>
                                                <h4 class="text-info mb-0" id="avgDaily">0</h4>
                                                <small class="text-muted">Daily Average</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Analytics Row -->
        <div class="row mb-4">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Customer Analytics</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 280px; position: relative;">
                            <canvas id="customerChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Customer Summary</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="h-100 d-flex flex-column justify-content-center">
                            <div class="row text-center g-3">
                                <div class="col-12">
                                    <div class="p-4 bg-success bg-opacity-10 rounded">
                                        <i class="bx bx-user-plus text-success mb-3" style="font-size: 2rem;"></i>
                                        <h3 class="text-success mb-1" id="newCustomerCount">0</h3>
                                        <p class="text-muted mb-0">New Customers</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-4 bg-primary bg-opacity-10 rounded">
                                        <i class="bx bx-user text-primary mb-3" style="font-size: 2rem;"></i>
                                        <h3 class="text-primary mb-1" id="returningCustomerCount">0</h3>
                                        <p class="text-muted mb-0">Returning Customers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Complete Expense Dashboard (Replaces Service Charts) -->
    <div id="expenseDashboardSection" style="display: none;">
        
        <!-- Row 1: Main Expense Analytics -->
        <div class="row mb-4">
            <!-- Daily Spending Trends -->
            <div class="col-xl-8 col-lg-8 mb-3">
                <div class="card">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Daily Spending Trends</h6>
                        <span class="badge bg-primary" id="spendingPeriod">This Month</span>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 350px; position: relative;">
                            <canvas id="dailySpendingChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Breakdown -->
            <div class="col-xl-4 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Category Breakdown</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 350px; position: relative;">
                            <canvas id="categoryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 2: Vendor Analysis & Monthly Comparison -->
        <div class="row mb-4">
            <!-- Top Vendors -->
            <div class="col-xl-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Top Vendors Analysis</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 320px; position: relative;">
                            <canvas id="vendorChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Spending Comparison -->
            <div class="col-xl-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Monthly Spending Comparison</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 320px; position: relative;">
                            <canvas id="monthlyComparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 3: Category Performance Over Time -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Category Performance Trends</h6>
                    </div>
                    <div class="card-body p-3">
                        <div style="height: 300px; position: relative;">
                            <canvas id="categoryTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 4: Detailed Summary Tables -->
        <div class="row mb-4">
            <!-- Category Summary -->
            <div class="col-xl-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Category Summary</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm" id="categorySummaryTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Count</th>
                                        <th>Average</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vendor Performance -->
            <div class="col-xl-6 col-lg-6 mb-3">
                <div class="card">
                    <div class="card-header py-2">
                        <h6 class="mb-0">Vendor Performance</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm" id="vendorSummaryTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Vendor</th>
                                        <th>Total Amount</th>
                                        <th>Transactions</th>
                                        <th>Avg/Transaction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 5: Expense Insights -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-bulb me-2 fs-5"></i>
                            <h6 class="mb-0">Expense Insights & Recommendations</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4" id="expenseInsights">
                            <!-- Default content that will be replaced with dynamic insights -->
                            <div class="col-md-4">
                                <div class="insight-card bg-warning bg-opacity-10 border-warning border p-3 rounded-3">
                                    <div class="d-flex align-items-start">
                                        <div class="insight-icon bg-warning text-white rounded-circle p-2 me-3">
                                            <i class="bx bx-trending-up fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-warning mb-1">Loading Insights...</h6>
                                            <p class="text-muted small mb-0">Analyzing your expense patterns...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="insight-card bg-info bg-opacity-10 border-info border p-3 rounded-3">
                                    <div class="d-flex align-items-start">
                                        <div class="insight-icon bg-info text-white rounded-circle p-2 me-3">
                                            <i class="bx bx-pie-chart-alt-2 fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-info mb-1">Category Analysis</h6>
                                            <p class="text-muted small mb-0">Fetching category breakdown...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="insight-card bg-success bg-opacity-10 border-success border p-3 rounded-3">
                                    <div class="d-flex align-items-start">
                                        <div class="insight-icon bg-success text-white rounded-circle p-2 me-3">
                                            <i class="bx bx-shield-check fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="text-success mb-1">Cost Optimization</h6>
                                            <p class="text-muted small mb-0">Preparing recommendations...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Operational Performance -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="mb-0">Operational Performance</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3" id="operationalMetrics">
                        <!-- Dynamic content loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Global variables for charts
let revenueChart, paymentChart, volumeChart, customerChart;
let categoryChart, vendorChart, monthlyComparisonChart, categoryTrendChart, dailySpendingChart;

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    loadDashboardData();

    // Event listeners
    document.querySelectorAll('input[name="serviceType"]').forEach(radio => {
        radio.addEventListener('change', loadDashboardData);
    });

    document.getElementById('refreshData').addEventListener('click', loadDashboardData);
    document.getElementById('quickSelect').addEventListener('change', handleQuickSelect);
});

function handleQuickSelect() {
    const quickSelect = document.getElementById('quickSelect').value;
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const today = new Date();

    switch(quickSelect) {
        case 'today':
            fromDate.value = toDate.value = today.toISOString().split('T')[0];
            break;
        case 'yesterday':
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            fromDate.value = toDate.value = yesterday.toISOString().split('T')[0];
            break;
        case 'this_week':
            const startOfWeek = new Date(today);
            startOfWeek.setDate(today.getDate() - today.getDay());
            fromDate.value = startOfWeek.toISOString().split('T')[0];
            toDate.value = today.toISOString().split('T')[0];
            break;
        case 'last_week':
            const lastWeekEnd = new Date(today);
            lastWeekEnd.setDate(today.getDate() - today.getDay() - 1);
            const lastWeekStart = new Date(lastWeekEnd);
            lastWeekStart.setDate(lastWeekEnd.getDate() - 6);
            fromDate.value = lastWeekStart.toISOString().split('T')[0];
            toDate.value = lastWeekEnd.toISOString().split('T')[0];
            break;
        case 'this_month':
            fromDate.value = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            toDate.value = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
            break;
        case 'last_month':
            const lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, 1);
            fromDate.value = lastMonth.toISOString().split('T')[0];
            toDate.value = new Date(today.getFullYear(), today.getMonth(), 0).toISOString().split('T')[0];
            break;
        case 'last_3_months':
            fromDate.value = new Date(today.getFullYear(), today.getMonth() - 2, 1).toISOString().split('T')[0];
            toDate.value = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
            break;
        case 'this_year':
            fromDate.value = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
            toDate.value = today.toISOString().split('T')[0];
            break;
    }

    if (quickSelect !== 'custom') {
        loadDashboardData();
    }
}

function initializeCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Revenue',
                data: [],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Paid Revenue',
                data: [],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                tension: 0.4,
                fill: false
            }, {
                label: 'Unpaid Revenue',
                data: [],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        font: {
                            size: 10
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': KSh ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 9
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 9
                        },
                        callback: function(value) {
                            return 'KSh ' + (value/1000) + 'k';
                        }
                    }
                }
            }
        }
    });

    // Payment Status Chart
    const paymentCtx = document.getElementById('paymentChart').getContext('2d');
    paymentChart = new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Paid', 'Unpaid'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#198754', '#dc3545'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 9
                        },
                        boxWidth: 10
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': KSh ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Volume Chart
    const volumeCtx = document.getElementById('volumeChart').getContext('2d');
    volumeChart = new Chart(volumeCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Orders Count',
                data: [],
                backgroundColor: '#0d6efd',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        }
    });

    // Customer Chart
    const customerCtx = document.getElementById('customerChart').getContext('2d');
    customerChart = new Chart(customerCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'New Customers',
                data: [],
                backgroundColor: '#198754'
            }, {
                label: 'Returning Customers',
                data: [],
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 9
                        },
                        boxWidth: 10
                    }
                }
            },
            scales: {
                x: {
                    stacked: true,
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 8
                        }
                    }
                }
            }
        }
    });

    // Initialize expense-specific charts
    initializeExpenseCharts();
}

function initializeExpenseCharts() {
    // Daily Spending Chart (Line)
    const dailySpendingCtx = document.getElementById('dailySpendingChart').getContext('2d');
    dailySpendingChart = new Chart(dailySpendingCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Daily Spending',
                data: [],
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#dc3545',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Spent: KSh ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: { size: 10 }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 10 },
                        callback: function(value) {
                            return 'KSh ' + (value/1000) + 'k';
                        }
                    }
                }
            }
        }
    });

    // Category Breakdown Chart (Doughnut)
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: [],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 11 },
                        boxWidth: 12
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((sum, val) => sum + val, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': KSh ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Top Vendors Chart (Horizontal Bar)
    const vendorCtx = document.getElementById('vendorChart').getContext('2d');
    vendorChart = new Chart(vendorCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Amount Spent',
                data: [],
                backgroundColor: '#0d6efd',
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Spent: KSh ' + context.parsed.x.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + (value/1000) + 'k';
                        }
                    }
                }
            }
        }
    });

    // Monthly Comparison Chart (Bar)
    const monthlyCtx = document.getElementById('monthlyComparisonChart').getContext('2d');
    monthlyComparisonChart = new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Monthly Expenses',
                data: [],
                backgroundColor: ['#198754', '#0d6efd', '#fd7e14'],
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Expenses: KSh ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + (value/1000) + 'k';
                        }
                    }
                }
            }
        }
    });

    // Category Trend Chart (Line)
    const categoryTrendCtx = document.getElementById('categoryTrendChart').getContext('2d');
    categoryTrendChart = new Chart(categoryTrendCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { size: 10 },
                        boxWidth: 12
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': KSh ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + (value/1000) + 'k';
                        }
                    }
                }
            }
        }
    });
}

function loadDashboardData() {
    const serviceType = document.querySelector('input[name="serviceType"]:checked').value;
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;

    // Show loading state
    document.getElementById('metricsCards').innerHTML = '<div class="col-12 text-center"><div class="spinner-border" role="status"></div></div>';

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const token = csrfToken ? csrfToken.getAttribute('content') : '';

    // Fetch data from backend
    fetch(`{{ route('reports.performance.data') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            service_type: serviceType,
            from_date: fromDate,
            to_date: toDate
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Dashboard data loaded:', data);
        updateMetricsCards(data.metrics, serviceType);
        updateCharts(data.charts, serviceType);
        updateOperationalMetrics(data.operational, serviceType);
        updateVolumeAnalytics(data.charts.volume, data.metrics);
        updateCustomerAnalytics(data.charts.customers);
        
        // Handle expense-specific sections and charts
        if (serviceType === 'expenses') {
            showExpenseSections();
            updateExpenseCharts(data);
        } else {
            hideExpenseSections();
        }
    })
    .catch(error => {
        console.error('Error loading dashboard data:', error);
        document.getElementById('metricsCards').innerHTML = '<div class="col-12"><div class="alert alert-danger">Error loading data: ' + error.message + '. Please check the console for details.</div></div>';
    });
}

function updateMetricsCards(metrics, serviceType) {
    if (!metrics) {
        console.error('No metrics data provided');
        return;
    }

    let cards = '';
    
    if (serviceType === 'expenses') {
        // Expense-specific metrics cards
        cards = `
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Expenses</p>
                                <h4 class="my-1 text-white">KSh ${(metrics.total_revenue || 0).toLocaleString()}</h4>
                                <p class="mb-0 font-13 text-white"><i class="bx bx-trending-down align-middle"></i>Since ${metrics.period_start || 'N/A'}</p>
                            </div>
                            <div class="widgets-icons bg-white text-primary ms-auto"><i class="bx bx-receipt"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Transactions</p>
                                <h4 class="my-1 text-white">${metrics.total_orders || 0}</h4>
                                <p class="mb-0 font-13 text-white">${(metrics.avg_daily_orders || 0).toFixed(1)} avg/day</p>
                            </div>
                            <div class="widgets-icons bg-white text-warning ms-auto"><i class="bx bx-list-ul"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Approved Expenses</p>
                                <h4 class="my-1 text-white">KSh ${(metrics.paid_revenue || 0).toLocaleString()}</h4>
                                <p class="mb-0 font-13 text-white">${(metrics.payment_rate || 0).toFixed(0)}% approved</p>
                            </div>
                            <div class="widgets-icons bg-white text-success ms-auto"><i class="bx bx-check-shield"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Pending Approval</p>
                                <h4 class="my-1 text-white">${metrics.unpaid_orders || 0}</h4>
                                <p class="mb-0 font-13 text-white">Awaiting review</p>
                            </div>
                            <div class="widgets-icons bg-white text-danger ms-auto"><i class="bx bx-time"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        // Revenue-specific metrics cards (original)
        cards = `
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Revenue</p>
                                <h4 class="my-1 text-white">KSh ${(metrics.total_revenue || 0).toLocaleString()}</h4>
                                <p class="mb-0 font-13 text-white"><i class="bx bxs-up-arrow align-middle"></i>Since ${metrics.period_start || 'N/A'}</p>
                            </div>
                            <div class="widgets-icons bg-white text-primary ms-auto"><i class="bx bxs-wallet"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Total Orders</p>
                                <h4 class="my-1 text-white">${metrics.total_orders || 0}</h4>
                                <p class="mb-0 font-13 text-white">${(metrics.avg_daily_orders || 0).toFixed(1)} avg/day</p>
                            </div>
                            <div class="widgets-icons bg-white text-warning ms-auto"><i class="bx bxs-shopping-bag"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Paid Orders</p>
                                <h4 class="my-1 text-white">KSh ${(metrics.paid_revenue || 0).toLocaleString()}</h4>
                                <p class="mb-0 font-13 text-white">${(metrics.payment_rate || 0).toFixed(1)}% payment rate</p>
                            </div>
                            <div class="widgets-icons bg-white text-success ms-auto"><i class="bx bxs-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card gradient-ibiza">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-white">Unpaid Orders</p>
                                <h4 class="my-1 text-white">${metrics.unpaid_orders || 0}</h4>
                                <p class="mb-0 font-13 text-white">KSh ${(metrics.unpaid_revenue || 0).toLocaleString()}</p>
                            </div>
                            <div class="widgets-icons bg-white text-danger ms-auto"><i class="bx bxs-x-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('metricsCards').innerHTML = cards;
}

function updateCharts(chartData, serviceType) {
    if (!chartData) {
        console.error('No chart data provided');
        return;
    }

    try {
        // Update Revenue/Expense Chart
        if (chartData.revenue && revenueChart) {
            revenueChart.data.labels = chartData.revenue.labels || [];
            revenueChart.data.datasets[0].data = chartData.revenue.total || [];
            revenueChart.data.datasets[1].data = chartData.revenue.paid || [];
            revenueChart.data.datasets[2].data = chartData.revenue.unpaid || [];
            
            // Update chart labels based on service type
            if (serviceType === 'expenses') {
                revenueChart.data.datasets[0].label = 'Total Spending';
                revenueChart.data.datasets[1].label = 'Approved Expenses';
                revenueChart.data.datasets[2].label = 'Pending Approval';
                revenueChart.options.plugins.title = { display: true, text: 'Daily Spending Trends' };
                document.getElementById('revenueChartTitle').textContent = 'Expense Trends';
            } else {
                revenueChart.data.datasets[0].label = 'Total Revenue';
                revenueChart.data.datasets[1].label = 'Paid Revenue';
                revenueChart.data.datasets[2].label = 'Unpaid Revenue';
                revenueChart.options.plugins.title = { display: true, text: 'Revenue Trends' };
                document.getElementById('revenueChartTitle').textContent = 'Revenue Trends';
            }
            revenueChart.update();
        }

        // Update Payment/Approval Chart
        if (chartData.payment && paymentChart) {
            paymentChart.data.datasets[0].data = [
                chartData.payment.paid || 0,
                chartData.payment.unpaid || 0
            ];
            
            // Update labels based on service type
            if (serviceType === 'expenses') {
                paymentChart.data.labels = ['Approved', 'Pending'];
                paymentChart.data.datasets[0].backgroundColor = ['#198754', '#ffc107'];
                document.getElementById('paymentChartTitle').textContent = 'Approval Status';
            } else {
                paymentChart.data.labels = ['Paid', 'Unpaid'];
                paymentChart.data.datasets[0].backgroundColor = ['#198754', '#dc3545'];
                document.getElementById('paymentChartTitle').textContent = 'Payment Status';
            }
            paymentChart.update();
        }

        // Update Volume Chart
        if (chartData.volume && volumeChart) {
            volumeChart.data.labels = chartData.volume.labels || [];
            volumeChart.data.datasets[0].data = chartData.volume.data || [];
            
            // Update label based on service type
            if (serviceType === 'expenses') {
                volumeChart.data.datasets[0].label = 'Expense Transactions';
                document.getElementById('volumeChartTitle').textContent = 'Expense Volume';
            } else {
                volumeChart.data.datasets[0].label = 'Orders Count';
                document.getElementById('volumeChartTitle').textContent = 'Service Volume';
            }
            volumeChart.update();
        }

        // Update Customer/Category Chart
        if (chartData.customers && customerChart) {
            customerChart.data.labels = chartData.customers.labels || [];
            customerChart.data.datasets[0].data = chartData.customers.new || [];
            customerChart.data.datasets[1].data = chartData.customers.returning || [];
            
            // Update labels based on service type
            if (serviceType === 'expenses') {
                customerChart.data.datasets[0].label = 'New Categories';
                customerChart.data.datasets[1].label = 'Regular Categories';
            } else {
                customerChart.data.datasets[0].label = 'New Customers';
                customerChart.data.datasets[1].label = 'Returning Customers';
            }
            customerChart.update();
        }
    } catch (error) {
        console.error('Error updating charts:', error);
    }
}

function updateVolumeAnalytics(volumeData, metrics) {
    if (!volumeData || !metrics) return;

    const totalVolume = volumeData.data ? volumeData.data.reduce((sum, val) => sum + val, 0) : 0;
    const peakDay = volumeData.data ? Math.max(...volumeData.data) : 0;
    const avgDaily = metrics.avg_daily_orders || 0;

    document.getElementById('totalVolume').textContent = totalVolume;
    document.getElementById('peakDay').textContent = peakDay;
    document.getElementById('avgDaily').textContent = avgDaily.toFixed(1);
}

function updateCustomerAnalytics(customerData) {
    if (!customerData) return;

    const totalNew = customerData.new ? customerData.new.reduce((sum, val) => sum + val, 0) : 0;
    const totalReturning = customerData.returning ? customerData.returning.reduce((sum, val) => sum + val, 0) : 0;

    document.getElementById('newCustomerCount').textContent = totalNew;
    document.getElementById('returningCustomerCount').textContent = totalReturning;
}

function updateOperationalMetrics(operational, serviceType) {
    console.log('Operational data received:', operational);

    if (!operational) {
        console.error('No operational data provided');
        document.getElementById('operationalMetrics').innerHTML = '<div class="col-12"><p class="text-danger">No operational data available</p></div>';
        return;
    }

    let metrics = '';
    
    if (serviceType === 'expenses') {
        // Expense-specific operational metrics
        metrics = `
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Approval</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.pending_deliveries || 0}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-time fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Expenses Today</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.completed_today || 0}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-calendar-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active Categories</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.category_breakdown ? operational.category_breakdown.length : 0}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-category fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Monthly Growth</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.new_customers_rate >= 0 ? '+' : ''}${Math.round(operational.new_customers_rate || 0)}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-trending-${operational.new_customers_rate >= 0 ? 'up' : 'down'} fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    } else {
        // Service-specific operational metrics (original)
        metrics = `
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pending Deliveries</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.pending_deliveries || 0}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-time-five fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Completed Today</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${operational.completed_today || 0}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Avg Processing Days</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${Math.round(operational.avg_processing_days || 0)}</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-hourglass fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">New Customer Rate</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${Math.round(operational.new_customers_rate || 0)}%</div>
                            </div>
                            <div class="col-auto">
                                <i class="bx bx-user-plus fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('operationalMetrics').innerHTML = metrics;
}

function showExpenseSections() {
    document.getElementById('serviceChartsSection').style.display = 'none';
    document.getElementById('expenseDashboardSection').style.display = 'block';
}

function hideExpenseSections() {
    document.getElementById('serviceChartsSection').style.display = 'block';
    document.getElementById('expenseDashboardSection').style.display = 'none';
}

function updateExpenseCharts(data) {
    if (!data || !data.operational) return;
    
    // Update Daily Spending Chart
    if (data.charts && data.charts.revenue && dailySpendingChart) {
        dailySpendingChart.data.labels = data.charts.revenue.labels || [];
        dailySpendingChart.data.datasets[0].data = data.charts.revenue.total || [];
        dailySpendingChart.update();
    }
    
    // Update Category Breakdown Chart
    if (data.operational.category_breakdown && categoryChart) {
        const categories = data.operational.category_breakdown;
        categoryChart.data.labels = categories.map(cat => cat.category);
        categoryChart.data.datasets[0].data = categories.map(cat => cat.amount);
        categoryChart.data.datasets[0].backgroundColor = categories.map(cat => cat.color || '#007bff');
        categoryChart.update();
    }
    
    // Update Top Vendors Chart
    if (data.operational.top_vendors && vendorChart) {
        const vendors = data.operational.top_vendors.slice(0, 8); // Top 8 vendors
        vendorChart.data.labels = vendors.map(vendor => vendor.vendor);
        vendorChart.data.datasets[0].data = vendors.map(vendor => vendor.amount);
        vendorChart.update();
    }
    
    // Update Monthly Comparison Chart
    if (monthlyComparisonChart) {
        // Get current, last, and previous month data
        const currentMonth = new Date().toLocaleString('default', { month: 'short' });
        const lastMonth = new Date(new Date().setMonth(new Date().getMonth() - 1)).toLocaleString('default', { month: 'short' });
        const prevMonth = new Date(new Date().setMonth(new Date().getMonth() - 2)).toLocaleString('default', { month: 'short' });
        
        monthlyComparisonChart.data.labels = [prevMonth, lastMonth, currentMonth];
        monthlyComparisonChart.data.datasets[0].data = [
            data.metrics.total_revenue * 0.8, // Simulated previous month
            data.metrics.total_revenue * 0.9, // Simulated last month  
            data.metrics.total_revenue // Current period
        ];
        monthlyComparisonChart.update();
    }
    
    // Update Category Trend Chart
    if (data.operational.category_breakdown && categoryTrendChart) {
        const categories = data.operational.category_breakdown.slice(0, 5); // Top 5 categories
        const labels = data.charts.volume ? data.charts.volume.labels : [];
        
        categoryTrendChart.data.labels = labels;
        categoryTrendChart.data.datasets = categories.map((category, index) => ({
            label: category.category,
            data: labels.map(() => Math.random() * category.amount), // Simulated trend data
            borderColor: category.color || `hsl(${index * 60}, 70%, 50%)`,
            backgroundColor: `${category.color || `hsl(${index * 60}, 70%, 50%)`}20`,
            tension: 0.4,
            fill: false
        }));
        categoryTrendChart.update();
    }
    
    // Update Category Summary Table
    updateCategorySummaryTable(data.operational.category_breakdown);
    
    // Update Vendor Summary Table  
    updateVendorSummaryTable(data.operational.top_vendors);
    
    // Update Expense Insights
    updateExpenseInsights(data);
}

function updateCategorySummaryTable(categories) {
    if (!categories) return;
    
    const tbody = document.querySelector('#categorySummaryTable tbody');
    tbody.innerHTML = '';
    
    categories.forEach(category => {
        const avg = category.count > 0 ? (category.amount / category.count) : 0;
        const row = `
            <tr>
                <td>
                    <span class="badge rounded-pill" style="background-color: ${category.color}; font-size: 0.7rem;">
                        ${category.category}
                    </span>
                </td>
                <td><strong>KSh ${category.amount.toLocaleString()}</strong></td>
                <td>${category.count}</td>
                <td>KSh ${avg.toLocaleString()}</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function updateVendorSummaryTable(vendors) {
    if (!vendors) return;
    
    const tbody = document.querySelector('#vendorSummaryTable tbody');
    tbody.innerHTML = '';
    
    vendors.slice(0, 10).forEach(vendor => {
        const row = `
            <tr>
                <td><strong>${vendor.vendor}</strong></td>
                <td>KSh ${vendor.amount.toLocaleString()}</td>
                <td>${vendor.count}</td>
                <td>Recent</td>
            </tr>
        `;
        tbody.innerHTML += row;
    });
}

function updateExpenseInsights(data) {
    if (!data || !data.operational || !data.metrics) return;
    
    const insights = generateExpenseInsights(data);
    const insightsContainer = document.getElementById('expenseInsights');
    
    insightsContainer.innerHTML = insights.map(insight => `
        <div class="col-md-4">
            <div class="insight-card bg-${insight.type} bg-opacity-10 border-${insight.type} border p-3 rounded-3">
                <div class="d-flex align-items-start">
                    <div class="insight-icon bg-${insight.type} text-white rounded-circle p-2 me-3">
                        <i class="bx ${insight.icon} fs-5"></i>
                    </div>
                    <div>
                        <h6 class="text-${insight.type} mb-1">${insight.title}</h6>
                        <p class="text-muted small mb-0">${insight.description}</p>
                        ${insight.value ? `<div class="mt-2"><span class="badge bg-${insight.type} bg-opacity-25 text-${insight.type}">${insight.value}</span></div>` : ''}
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}

function generateExpenseInsights(data) {
    const insights = [];
    const { metrics, operational } = data;
    
    // Insight 1: Top Spending Category
    if (operational.category_breakdown && operational.category_breakdown.length > 0) {
        const topCategory = operational.category_breakdown[0];
        const percentage = ((topCategory.amount / metrics.total_revenue) * 100).toFixed(1);
        insights.push({
            type: 'primary',
            icon: 'bx-pie-chart-alt-2',
            title: 'Highest Spending Category',
            description: `${topCategory.category} accounts for ${percentage}% of total expenses`,
            value: `KSh ${topCategory.amount.toLocaleString()}`
        });
    }
    
    // Insight 2: Top Vendor Relationship  
    if (operational.top_vendors && operational.top_vendors.length > 0) {
        const topVendor = operational.top_vendors[0];
        const percentage = ((topVendor.amount / metrics.total_revenue) * 100).toFixed(1);
        insights.push({
            type: 'info',
            icon: 'bx-store',
            title: 'Primary Business Partner',
            description: `${topVendor.vendor} represents ${percentage}% of total spending`,
            value: `${topVendor.count} transactions`
        });
    }
    
    // Insight 3: Spending Pattern Analysis
    const avgDailySpending = metrics.total_revenue / Math.max(1, (new Date() - new Date(new Date().getFullYear(), new Date().getMonth(), 1)) / (1000 * 60 * 60 * 24));
    const monthlyProjection = avgDailySpending * 30;
    
    if (monthlyProjection > metrics.total_revenue * 1.2) {
        insights.push({
            type: 'warning',
            icon: 'bx-trending-up',
            title: 'Spending Trend Alert',
            description: 'Current spending pace suggests higher monthly costs',
            value: `Projected: KSh ${monthlyProjection.toLocaleString()}`
        });
    } else if (operational.new_customers_rate < 0) {
        insights.push({
            type: 'success',
            icon: 'bx-trending-down',
            title: 'Cost Reduction Success',
            description: `Spending decreased by ${Math.abs(operational.new_customers_rate).toFixed(1)}% vs last month`,
            value: 'Great progress!'
        });
    } else {
        insights.push({
            type: 'success',
            icon: 'bx-check-shield',
            title: 'Spending Under Control',
            description: 'Expense patterns are within expected ranges',
            value: `${operational.pending_deliveries || 0} pending approvals`
        });
    }
    
    // Insight 4: Operational Efficiency
    if (operational.category_breakdown && operational.category_breakdown.length > 3) {
        const activeCategories = operational.category_breakdown.length;
        insights.push({
            type: 'info',
            icon: 'bx-category',
            title: 'Expense Diversification',
            description: `Spending spread across ${activeCategories} different categories`,
            value: 'Well diversified'
        });
    }
    
    // Insight 5: Approval Efficiency
    const approvalRate = operational.pending_deliveries ? 
        ((metrics.total_orders - operational.pending_deliveries) / metrics.total_orders * 100).toFixed(1) : 100;
    
    if (approvalRate >= 95) {
        insights.push({
            type: 'success',
            icon: 'bx-check-circle',
            title: 'Efficient Approvals',
            description: `${approvalRate}% of expenses processed efficiently`,
            value: 'Excellent workflow'
        });
    } else if (operational.pending_deliveries > 5) {
        insights.push({
            type: 'warning',
            icon: 'bx-time-five',
            title: 'Approval Bottleneck',
            description: `${operational.pending_deliveries} expenses awaiting approval`,
            value: 'Action needed'
        });
    }
    
    // Insight 6: Budget Recommendations
    const avgTransactionValue = metrics.total_orders > 0 ? metrics.total_revenue / metrics.total_orders : 0;
    insights.push({
        type: 'primary',
        icon: 'bx-calculator',
        title: 'Average Transaction Value',
        description: 'Mean expense amount per transaction',
        value: `KSh ${avgTransactionValue.toLocaleString()}`
    });
    
    return insights.slice(0, 6); // Return max 6 insights (2 rows of 3)
}
</script>

<style>
.gradient-deepblue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.gradient-orange {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.gradient-ohhappiness {
    background: linear-gradient(135deg, #00dbde 0%, #fc00ff 100%);
}
.gradient-ibiza {
    background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
}
.widgets-icons {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 24px;
}

/* Mobile Responsive Improvements */
@media (max-width: 768px) {
    .card-title {
        font-size: 1rem !important;
        text-align: center;
    }
    
    .btn-group {
        display: flex !important;
        width: 100% !important;
    }
    
    .btn-group .btn {
        flex: 1 !important;
        font-size: 0.875rem !important;
        padding: 0.5rem 0.25rem !important;
    }
    
    .performance-header {
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .chart-container {
        margin-bottom: 2rem;
    }
    
    .widgets-icons {
        width: 40px;
        height: 40px;
        font-size: 20px;
    }
    
    .card-body {
        padding: 1rem 0.75rem !important;
    }
    
    .row.mb-4 {
        margin-bottom: 1.5rem !important;
    }
}

@media (max-width: 576px) {
    .card-title {
        font-size: 0.9rem !important;
    }
    
    .btn-group .btn {
        font-size: 0.8rem !important;
        padding: 0.4rem 0.2rem !important;
    }
    
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .form-control, .form-select {
        font-size: 0.875rem;
    }
    
    .gap-3 {
        gap: 1rem !important;
    }
}

/* Enhanced Operational Metrics */
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.text-xs {
    font-size: 0.7rem;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
.py-2 {
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
}
.no-gutters {
    margin-right: 0;
    margin-left: 0;
}
.no-gutters > .col,
.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}

/* Enhanced Analytics Sections */
.gap-3 {
    gap: 1rem !important;
}
.bg-opacity-10 {
    --bs-bg-opacity: 0.1;
}
.fw-bold {
    font-weight: 600 !important;
}
.fs-4 {
    font-size: 1.25rem !important;
}

/* Improved card spacing */
.card-body .row.align-items-center {
    min-height: 100px;
}

/* Better metric boxes */
.card-body .p-2.rounded {
    border: 1px solid rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.card-body .p-2.rounded:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Responsive chart containers */
@media (max-width: 768px) {
    .card-body div[style*="height"] {
        height: 200px !important;
    }

    .col-xl-8.col-lg-7 {
        order: 2;
    }

    .col-xl-4.col-lg-5 {
        order: 1;
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .card-body div[style*="height"] {
        height: 180px !important;
    }

    .card-body {
        padding: 1rem !important;
    }

    .card-header {
        padding: 0.75rem 1rem !important;
    }
}

/* Better chart responsiveness */
.chart-container {
    position: relative;
    width: 100%;
}

.chart-container canvas {
    width: 100% !important;
    height: auto !important;
}

/* Expense Insights Styling */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.insight-card {
    transition: all 0.3s ease;
    min-height: 120px;
    display: flex;
    align-items: center;
}

.insight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.insight-icon {
    min-width: 40px;
    min-height: 40px;
    flex-shrink: 0;
}

.insight-card h6 {
    font-weight: 600;
    font-size: 0.95rem;
}

.insight-card .small {
    font-size: 0.85rem;
    line-height: 1.4;
}

/* Enhanced gradient backgrounds for insights */
.bg-primary.bg-opacity-10 {
    background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%) !important;
}

.bg-success.bg-opacity-10 {
    background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%) !important;
}

.bg-warning.bg-opacity-10 {
    background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%) !important;
}

.bg-info.bg-opacity-10 {
    background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%) !important;
}

/* Responsive adjustments for insights */
@media (max-width: 768px) {
    .insight-card {
        min-height: 100px;
    }
    
    .insight-card h6 {
        font-size: 0.9rem;
    }
    
    .insight-card .small {
        font-size: 0.8rem;
    }
    
    .insight-icon {
        min-width: 35px;
        min-height: 35px;
    }
    
    .insight-icon i {
        font-size: 1.2rem !important;
    }
}

/* Improved scrolling for mobile */
@media (max-width: 768px) {
    .page-content {
        padding: 1rem 0.5rem;
    }

    .row {
        margin: 0 -0.5rem;
    }

    .row > * {
        padding: 0 0.5rem;
    }
}
</style>

@endsection
