@extends('accounts.layouts.app')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">
        <!-- [Invoices Awaiting Payment] start -->
                <div class="col-xxl-3 col-md-6">
                        <div class="card stretch-full">
                            <div class="card-body" style="
                        padding-bottom: 1px;
                    ">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div>
                                        <div class="d-flex gap-4 align-items-center">
                                            <div class="avatar-text avatar-lg bg-gray-200">
                                                <i class="feather-users"></i>
                                            </div>
                                            <div>
                                                <div class="fs-4 fw-bold text-success"><span class="counter">2</span></div>
                                                <h3 class="fs-15 fw-semibold text-truncate-1-line">Total Easypaisa Customers</h3>
                                            </div>
                                        </div>
                                        <!-- Dummy text below icon and heading -->
                                        <p class="text-muted mb-0 mt-2">This number represents the total customers since Selected Date, all of whom are active.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                        <div class="card stretch-full">
                            <div class="card-body" style="
                        padding-bottom: 1px;
                    ">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div>
                                        <div class="d-flex gap-4 align-items-center">
                                            <div class="avatar-text avatar-lg bg-gray-200">
                                                <i class="feather-users"></i>
                                            </div>
                                            <div>
                                                <div class="fs-4 fw-bold text-success"><span class="counter">200,000</span></div>
                                                <h3 class="fs-15 fw-semibold text-truncate-1-line">Total Investments</h3>
                                            </div>
                                        </div>
                                        <!-- Dummy text below icon and heading -->
                                        <p class="text-muted mb-0 mt-2">This number represents the total Investments since Selected Date, all of whom are active.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="col-xxl-3 col-md-6">
                        <div class="card stretch-full">
                            <div class="card-body" style="
                        padding-bottom: 1px;
                    ">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div>
                                        <div class="d-flex gap-4 align-items-center">
                                            <div class="avatar-text avatar-lg bg-gray-200">
                                                <i class="feather-users"></i>
                                            </div>
                                            <div>
                                                <div class="fs-4 fw-bold text-success"><span class="counter">2630</span></div>
                                                <h3 class="fs-15 fw-semibold text-truncate-1-line">Total Profit Accured</h3>
                                            </div>
                                        </div>
                                        <!-- Dummy text below icon and heading -->
                                        <p class="text-muted mb-0 mt-2">This number represents the total Profit since Selected Date, all of whom are active.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>


                <div class="col-xxl-3 col-md-6">
                        <div class="card stretch-full">
                            <div class="card-body" style="
                        padding-bottom: 1px;
                    ">
                                <div class="d-flex align-items-start justify-content-between mb-4">
                                    <div>
                                        <div class="d-flex gap-4 align-items-center">
                                            <div class="avatar-text avatar-lg bg-gray-200">
                                                <i class="feather-users"></i>
                                            </div>
                                            <div>
                                                <div class="fs-4 fw-bold text-success"><span class="counter">2</span></div>
                                                <h3 class="fs-15 fw-semibold text-truncate-1-line">Total Withdrawals</h3>
                                            </div>
                                        </div>
                                        <!-- Dummy text below icon and heading -->
                                        <p class="text-muted mb-0 mt-2">This number represents the total Withdrawals since Selected Date, all of whom are active.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>



        
        <div class="col-xxl-12">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Investment Records</h5>
                    <div class="card-header-action">
                        <div class="card-header-btn">
                            <div data-bs-toggle="tooltip" title="Delete">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Refresh">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body custom-card-action p-0">
                    <div id="payment-records-chart"></div>
                </div>
               
            </div>
        </div>
    

        <!--! END: [Team Progress] !-->
    </div>

<!-- Include Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">

    <!-- Investment Over Time -->
    <div class="col-xxl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Investment Over Time</h5>
            </div>
            <div class="card-body">
                <canvas id="investmentOverTime"></canvas>
            </div>
        </div>
    </div>

    <!-- Profit by Day -->
    <div class="col-xxl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Profit by Day</h5>
            </div>
            <div class="card-body">
                <canvas id="profitByDay"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Withdrawals Table -->
    <div class="col-xxl-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Recent Withdrawals</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-04-06</td>
                            <td>John Doe</td>
                            <td>$150</td>
                        </tr>
                        <tr>
                            <td>2025-04-05</td>
                            <td>Jane Smith</td>
                            <td>$200</td>
                        </tr>
                        <tr>
                            <td>2025-04-04</td>
                            <td>Bob Johnson</td>
                            <td>$120</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
// Data
const labels = ['2025-04-01', '2025-04-02', '2025-04-03', '2025-04-04', '2025-04-05', '2025-04-06', '2025-04-07'];

// Investment Over Time
const investmentCtx = document.getElementById('investmentOverTime').getContext('2d');
new Chart(investmentCtx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Investment',
            data: [1000, 1500, 1200, 1800, 2000, 2200, 2500],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Investment Over Time'
            }
        }
    }
});

// Profit by Day
const profitCtx = document.getElementById('profitByDay').getContext('2d');
new Chart(profitCtx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Profit',
            data: [300, 400, 350, 500, 420, 600, 700],
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Profit by Day'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>




</div>

@endsection

@push('scripts')

@endpush
