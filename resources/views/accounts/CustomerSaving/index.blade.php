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


@endpush
@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card stretch stretch-full">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Customer Saving Master </h4>
                    <div class="dataTables_filter d-flex gap-2 align-items-center">
                        <input type="date" id="from_date" class="form-control" placeholder="From Date">
                        <input type="date" id="to_date" class="form-control" placeholder="To Date">
                        <input type="text" id="customSearch" class="form-control" placeholder="Search by name">
                        <button id="exportCsv" class="btn btn-success btn-lg">
                            <i class="fas fa-download"></i> Export CSV
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
                                    <th>Customer MSISDN</th>

<th>Initial Deposit</th>
<th>Plan</th>
<th>Activated Slab</th>
<th>Fund Growth Amount</th>
<th>Saving Status</th>
<th>Saving Start Date</th>
<th>Saving End Date</th>
<th>Tenure Days</th>
<th>Active Days</th>
<th>Maturity Status</th>
<th>Last Profit Calculated At</th>
<th>Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTable will populate this dynamically -->
                            </tbody>
                        </table>

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
    $(document).ready(function () {
        var table = $('#invTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('account.CustomerSavingsMaster') }}',
                data: function (d) {
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                    d.search_name = $('#customSearch').val();
                }
            },
            lengthChange: false,
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'user_msisdn', name: 'customer.user_msisdn' },
                { data: 'first_name', name: 'customer.first_name' },
                { data: 'last_name', name: 'customer.last_name' },
                { data: 'email_address', name: 'customer.email_address' },
                { data: 'customer_msisdn', name: 'customer_msisdn' },
                { data: 'initial_deposit', name: 'initial_deposit' },
                { data: 'plan', name: 'plan' },
                { data: 'activated_slab', name: 'activated_slab' },
                { data: 'fund_growth_amount', name: 'fund_growth_amount' },
                { data: 'saving_status', name: 'saving_status' },
                { data: 'saving_start_date', name: 'saving_start_date' },
                { data: 'saving_end_date', name: 'saving_end_date' },
                { data: 'tenure_days', name: 'tenure_days' },
                { data: 'active_days', name: 'active_days' },
                { data: 'maturity_status', name: 'maturity_status' },
                { data: 'last_profit_calculated_at', name: 'last_profit_calculated_at' },
                { data: 'created_at', name: 'created_at' }            ],
        });

        $('#from_date, #to_date, #customSearch').on('change keyup', function () {
            table.draw();
        });

        $('#exportCsv').on('click', function () {
            let from = $('#from_date').val();
            let to = $('#to_date').val();
            let search = $('#customSearch').val();
            window.location.href = '{{ route('account.exportCustomerSavingsMaster') }}?from_date=' + from + '&to_date=' + to + '&search_name=' + search;
        });
    });
</script>




   <!-- Global Required Scripts Start -->
   <script src="{{asset('admin/assets/js/jquery-3.3.1.min.js')}}"></script>
   <script src="{{asset('admin/assets/js/popper.min.js')}}"></script>
   <script src="{{asset('admin/assets/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('admin/assets/js/perfect-scrollbar.js')}}"> </script>
   <script src="{{asset('admin/assets/js/jquery-ui.min.js')}}"> </script>
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
<script src="{{asset('admin/assets/js/framework.js')}}"></script>
<!-- Settings -->
<script src="{{asset('admin/assets/js/settings.js')}}"></script>
@endpush
