@extends('superadmin.layouts.app')

@section('title')
    <title>Compaines || Index</title>
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
                    <h4>Compaines</h4>
                    <div class="dataTables_filter">
                        <input type="text" id="customSearch" class="form-control" placeholder="Search by name">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="myTables" class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Package Name</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
                                    <th>Registration Number</th>
                                    <th>NTN</th>
                                    <th>SECP Registration</th>
                                    <th>Business Type</th>
                                    <th>Authorized Capital</th>
                                    <th>Registration Date</th>
                                    <th>Active Status</th>
                                    <th>Status</th>
                                    <th>Package Assigned</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
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

<script type="text/javascript">
    $(function () {
        var table = $('#myTables').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('superadmin.compaines.index') }}",
            lengthChange: false, // Disable "Show X entries" dropdown
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'package_name', name: 'package_name' },
                { data: 'address', name: 'address' },
                { data: 'contact_number', name: 'contact_number' },
                { data: 'registration_number', name: 'registration_number' },
                { data: 'ntn', name: 'ntn' },
                { data: 'secp_registration', name: 'secp_registration' },
                { data: 'business_type', name: 'business_type' },
                { data: 'authorized_capital', name: 'authorized_capital' },
                { data: 'registration_date', name: 'registration_date' },
                { data: 'is_active', name: 'is_active' },
                { data: 'status', name: 'status' },
                { data: 'package_assigned', name: 'package_assigned' },
                { data: 'created_at', name: 'created_at' },

                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        // Custom search input
        $('#customSearch').on('keyup', function () {
            table.search(this.value).draw();
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
