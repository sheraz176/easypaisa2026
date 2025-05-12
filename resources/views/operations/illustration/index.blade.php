@extends('operations.layouts.app')

@section('title')
    <title>Refund Customer  || Index</title>
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
                        <h4>Illustration Report </h4>
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
                                       {{-- Customer Details --}}
                                       <th>User Name</th>
                                       <th>Msisdn</th>
                                       <th>Amount</th>
                                       <th>Contribution Term</th>
                                       <th>Sum Covered</th>
                                       <th>profit_at_9</th>
                                       <th>profit_at_13</th>
                                       <th>Date</th>

                                        <th>Actions</th>



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
        $(document).ready(function() {
            var table = $('#invTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('operation.illustrationReport') }}',
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'msisdn',
                        name: 'msisdn'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'contribution_term',
                        name: 'contribution_term'
                    },

                    {
                        data: 'sum_covered',
                        name: 'sum_covered'
                    },
                    {
                        data: 'profit_at_9',
                        name: 'profit_at_9'
                    },
                    {
                        data: 'profit_at_13',
                        name: 'profit_at_13'
                    },

                    {
    data: 'created_at',
    name: 'created_at'
},

{
    data: null,
    orderable: false,
    searchable: false,
    render: function(data, type, row) {
        return `
            <div class="d-flex gap-1">

                 <a href="/easypaisa/public/storage/pdfs/${row.pdf_path}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fas fa-file-pdf"></i> View PDF
                </a>
            </div>
        `;
    }
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
                window.location.href = '{{ route('operation.exportillustrationReport') }}?from_date=' + from +
                    '&to_date=' + to + '&search_name=' + search;

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
