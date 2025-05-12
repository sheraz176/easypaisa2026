@extends('accounts.layouts.app')

@section('title')
    <title>Investment Ledger Saving || Index</title>
@endsection
@push('styles')
    <!-- Datatable -->
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet">

    <style>
        .box {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            margin-top: 10px;
            border-radius: 5px;
        }
    </style>
@endpush
@section('content')
    <div class="main-content">
        <div class="row">

            <div class="col-lg-12">
                <div class="card stretch stretch-full">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Daily Return </h4>
                        <div class="dataTables_filter d-flex gap-2 align-items-center">
                            <input type="date" id="from_date" class="form-control" placeholder="From Date">
                            <input type="date" id="to_date" class="form-control" placeholder="To Date">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search by name">
                            <button id="exportCsv" class="btn btn-success btn-lg">
                                <i class="fas fa-download"></i> Export
                            </button>
                        </div>

                    </div>


                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="invTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- Customer Details --}}
                                        <th>User MSISDN</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email Address</th>



                                        {{-- Savings Details --}}
                                        <th>Plan</th>
                                        <th>Initial Deposit</th>

                                        <th>Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Transaction Type</th>
                                        <th>Date Time</th>
                                        <th>Net Amount</th>
                                        <th>Gross Amount</th>

                                        <th>Amount Earned</th>
                                        <th>Commulative Amount</th>
                                        <th>Fund Growth Amount</th>
                                        <th>EFU Share</th>
                                        <th>Easypaisa Share</th>
                                        <th>Customer Share</th>
                                        <th>Sum Assured</th>
                                        <th>Sum At Risk</th>
                                        <th>Mortality Charges</th>
                                        <th>PTF Share</th>
                                        <th>OSF Share</th>
                                        <th>Type</th>
                                        <th>Today's Interest Rate</th>
                                        <th>Easypaisa Share %</th>
                                        <th>EFU Share %</th>
                                        <th>Customer Share %</th>



                                        <th>Date</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTable will populate this dynamically -->
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Amount Earned</div>
                                    <h4><div id="totalAmountEarned">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Commulative Amount</div>
                                    <h4> <div id="totalCommulativeAmount">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Fund Growth Amount</div>
                                    <h4><div id="totalFundGrowthAmount">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Efu Share</div>
                                    <h4><div id="totalEfuShare">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Easypaisa Share</div>
                                    <h4><div id="totalEasypaisaShare">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Customer Share</div>
                                   <h4> <div id="totalCustomerShare">0.00</div>
                                   </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Sum Assured</div>
                                    <h4><div id="totalSumAssured">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Sum At Risk</div>
                                  <h4>  <div id="totalSumAtRisk">0.00</div>
                                  </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Mortality Charges</div>
                                    <h4><div id="totalMortalityCharges">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Ptf Share</div>
                                    <h4><div id="totalPtfShare">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Osf Share</div>
                                    <h4><div id="totalOsfShare">0.00</div>
                                    </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Type</div>
                                   <h4> <div id="totalType">0.00</div>
                                   </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Today's Interest Rate</div>
                                   <h4> <div id="totalTodaysInterestRate">0.00</div>
                                   </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Easypaisa Share Percentage</div>
                                  <h4>   <div id="totalEasypaisaSharePercentage">0.00</div>
                                  </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Efu Share Percentage</div>
                                   <h4> <div id="totalEfuSharePercentage">0.00</div>
                                   </h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box">
                                    <div>Total Customer Share Percentage</div>
                                   <h4> <div id="totalCustomerSharePercentage">0.00</div>
                                   </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Page Specific Scripts Finish -->

    <script>
        $(document).ready(function() {
            var table = $('#invTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('account.DailyReturn') }}',
                    data: function(d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.search_name = $('#customSearch').val();
                    }
                },
                lengthChange: false,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_msisdn',
                        name: 'customer.user_msisdn'
                    },
                    {
                        data: 'first_name',
                        name: 'customer.first_name'
                    },
                    {
                        data: 'last_name',
                        name: 'customer.last_name'
                    },
                    {
                        data: 'email_address',
                        name: 'customer.email_address'
                    },
                    {
                        data: 'plan',
                        name: 'savings.plan'
                    },
                    {
                        data: 'initial_deposit',
                        name: 'savings.initial_deposit'
                    },

                    {
                        data: 'transaction_id',
                        name: 'investmentLedgerSaving.transaction_id'
                    },
                    {
                        data: 'amount',
                        name: 'investmentLedgerSaving.amount'
                    },
                    {
                        data: 'transaction_type',
                        name: 'investmentLedgerSaving.transaction_type'
                    },
                    {
                        data: 'date_time',
                        name: 'investmentLedgerSaving.date_time'
                    },
                    {
                        data: 'net_amount',
                        name: 'investmentLedgerSaving.net_amount'
                    },
                    {
                        data: 'gross_amount',
                        name: 'investmentLedgerSaving.gross_amount'
                    },

                    {
                        data: 'amount_earned',
                        name: 'amount_earned'
                    },
                    {
                        data: 'commulative_amount',
                        name: 'commulative_amount'
                    },
                    {
                        data: 'fund_growth_amount',
                        name: 'fund_growth_amount'
                    },
                    {
                        data: 'efu_share',
                        name: 'efu_share'
                    },
                    {
                        data: 'easypaisa_share',
                        name: 'easypaisa_share'
                    },
                    {
                        data: 'customer_share',
                        name: 'customer_share'
                    },
                    {
                        data: 'sum_assured',
                        name: 'sum_assured'
                    },
                    {
                        data: 'sum_at_risk',
                        name: 'sum_at_risk'
                    },
                    {
                        data: 'mortality_charges',
                        name: 'mortality_charges'
                    },
                    {
                        data: 'ptf_share',
                        name: 'ptf_share'
                    },
                    {
                        data: 'osf_share',
                        name: 'osf_share'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'todays_interest_rate',
                        name: 'todays_interest_rate'
                    },
                    {
                        data: 'easypaisa_share_percentage',
                        name: 'easypaisa_share_percentage'
                    },
                    {
                        data: 'efu_share_percentage',
                        name: 'efu_share_percentage'
                    },
                    {
                        data: 'customer_share_percentage',
                        name: 'customer_share_percentage'
                    },


                    {
                        data: 'created_at',
                        name: 'created_at'
                    }
                ],
            });

            $('#from_date, #to_date, #customSearch').on('change keyup', function() {
                table.draw();
            });

            $('#exportCsv').on('click', function() {
                let from = $('#from_date').val();
                let to = $('#to_date').val();
                let search = $('#customSearch').val();
                window.location.href = '{{ route('account.exportDailyReturn') }}?from_date=' + from +
                    '&to_date=' + to + '&search_name=' + search;
            });
        });


        $(document).ready(function() {
            // Assuming you're using DataTables
            var table = $('#invTable').DataTable();

            // Function to calculate and update totals
            function updateTotals() {
                var totalAmountEarned = 0;
                var totalCommulativeAmount = 0;
                var totalFundGrowthAmount = 0;
                var totalEfuShare = 0;
                var totalEasypaisaShare = 0;
                var totalCustomerShare = 0;
                var totalSumAssured = 0;
                var totalSumAtRisk = 0;
                var totalMortalityCharges = 0;
                var totalPtfShare = 0;
                var totalOsfShare = 0;
                var totalType = 0;
                var totalTodaysInterestRate = 0;
                var totalEasypaisaSharePercentage = 0;
                var totalEfuSharePercentage = 0;
                var totalCustomerSharePercentage = 0;

                // Loop through each row and sum the necessary columns
                table.rows().every(function() {
                    var data = this.data(); // Get row data

                    totalAmountEarned += parseFloat(data.amount_earned) || 0;
                    totalCommulativeAmount += parseFloat(data.commulative_amount) || 0;
                    totalFundGrowthAmount += parseFloat(data.fund_growth_amount) || 0;
                    totalEfuShare += parseFloat(data.efu_share) || 0;
                    totalEasypaisaShare += parseFloat(data.easypaisa_share) || 0;
                    totalCustomerShare += parseFloat(data.customer_share) || 0;
                    totalSumAssured += parseFloat(data.sum_assured) || 0;
                    totalSumAtRisk += parseFloat(data.sum_at_risk) || 0;
                    totalMortalityCharges += parseFloat(data.mortality_charges) || 0;
                    totalPtfShare += parseFloat(data.ptf_share) || 0;
                    totalOsfShare += parseFloat(data.osf_share) || 0;
                    totalType += parseFloat(data.type) || 0;
                    totalTodaysInterestRate += parseFloat(data.todays_interest_rate) || 0;
                    totalEasypaisaSharePercentage += parseFloat(data.easypaisa_share_percentage) || 0;
                    totalEfuSharePercentage += parseFloat(data.efu_share_percentage) || 0;
                    totalCustomerSharePercentage += parseFloat(data.customer_share_percentage) || 0;
                });

                // Update the totals in the HTML boxes
                $('#totalAmountEarned').text(totalAmountEarned.toFixed(2));
                $('#totalCommulativeAmount').text(totalCommulativeAmount.toFixed(2));
                $('#totalFundGrowthAmount').text(totalFundGrowthAmount.toFixed(2));
                $('#totalEfuShare').text(totalEfuShare.toFixed(2));
                $('#totalEasypaisaShare').text(totalEasypaisaShare.toFixed(2));
                $('#totalCustomerShare').text(totalCustomerShare.toFixed(2));
                $('#totalSumAssured').text(totalSumAssured.toFixed(2));
                $('#totalSumAtRisk').text(totalSumAtRisk.toFixed(2));
                $('#totalMortalityCharges').text(totalMortalityCharges.toFixed(2));
                $('#totalPtfShare').text(totalPtfShare.toFixed(2));
                $('#totalOsfShare').text(totalOsfShare.toFixed(2));
                $('#totalType').text(totalType.toFixed(2));
                $('#totalTodaysInterestRate').text(totalTodaysInterestRate.toFixed(2));
                $('#totalEasypaisaSharePercentage').text(totalEasypaisaSharePercentage.toFixed(2));
                $('#totalEfuSharePercentage').text(totalEfuSharePercentage.toFixed(2));
                $('#totalCustomerSharePercentage').text(totalCustomerSharePercentage.toFixed(2));
            }

            // Call the function initially and every time the table data is updated
            updateTotals();

            // If you have sorting, paging, or filtering, call updateTotals again after table redraw
            table.on('draw', function() {
                updateTotals();
            });
        });
    </script>




    <!-- Global Required Scripts Start -->
    <script src="{{ asset('admin/assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Page Specific Scripts Finish -->
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap.min.js"></script> -->
    <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <!-- medjestic core JavaScript -->
    <script src="{{ asset('admin/assets/js/framework.js') }}"></script>
    <!-- Settings -->
    <script src="{{ asset('admin/assets/js/settings.js') }}"></script>
@endpush
