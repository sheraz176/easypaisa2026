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
                    <h4>Investment Ledger Saving </h4>
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

                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Transaction Type</th>
                                    <th>Net Amount</th>
                                    <th>Gross Amount</th>
                                    <th>Date Time</th>



                                    {{-- Savings Details --}}
                                    <th>Plan</th>
                                    <th>Initial Deposit</th>

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
                url: '{{ route('account.InvestmentLedger') }}',
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
                { data: 'transaction_id', name: 'transaction_id' },
                { data: 'amount', name: 'amount' },
                { data: 'transaction_type', name: 'transaction_type' },
                { data: 'net_amount', name: 'net_amount' },
                { data: 'gross_amount', name: 'gross_amount' },
                { data: 'date_time', name: 'date_time' },
                { data: 'plan', name: 'savings.plan' },
                { data: 'initial_deposit', name: 'savings.initial_deposit' }            ],
        });

        $('#from_date, #to_date, #customSearch').on('change keyup', function () {
            table.draw();
        });

        $('#exportCsv').on('click', function () {
            let from = $('#from_date').val();
            let to = $('#to_date').val();
            let search = $('#customSearch').val();
            window.location.href = '{{ route('account.InvestmentLedger.export') }}?from_date=' + from + '&to_date=' + to + '&search_name=' + search;
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
