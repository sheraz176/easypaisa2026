@extends('superadmin.layouts.app')

@section('title')
    <title>Slabs || Index</title>
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
                    <h4>Slabs</h4>
                    <div class="dataTables_filter">
                        <input type="text" id="customSearch" class="form-control" placeholder="Search by name">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="slabsTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Slab Name</th>
                                    <th>Package Name</th>
                                    <th>Initial Deposit</th>
                                    <th>Maximum Deposit</th>
                                    <th>Daily Return Rate (%)</th>
                                    <th>Actions</th>
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

<script>
    $(document).ready(function() {
        $('#slabsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('superadmin.Slabs.index') }}",
            lengthChange: false, // Disable "Show X entries" dropdown
            columns: [
                { data: 'id', name: 'id' },
                { data: 'slab_name', name: 'slab_name' },
                { data: 'package_name', name: 'package_name' },
                { data: 'initial_deposit', name: 'initial_deposit' },
                { data: 'maximum_deposit', name: 'maximum_deposit' },
                { data: 'daily_return_rate', name: 'daily_return_rate' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
   <!-- Global Required Scripts Start -->
   <script src="{{asset('admin/assets/js/jquery-3.3.1.min.js')}}"></script>
   <script src="{{asset('admin/assets/js/popper.min.js')}}"></>
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
