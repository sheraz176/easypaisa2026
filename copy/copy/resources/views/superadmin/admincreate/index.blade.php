@extends('superadmin.layouts.app')

@section('title')
    <title>Super Admin Users || Index</title>
@endsection
@push('styles')

 <!-- Datatable -->
 <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css" rel="stylesheet">
@endpush
@section('content')

 <!-- Body Content Wrapper -->
 <div class="ms-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('superadmin.admincreate.create')}}">Add Super Admin User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Super Admin Users List</li>
                </ol>
            </nav>
            <div class="ms-panel">
                <div class="ms-panel-header ms-panel-custome align-items-center">
                    <h6><span style="color: black">Super Admin Users</span> </h6>
                    <button class="btn btn-danger d-inline w-20" ><a href="{{route('superadmin.admincreate.create')}}" style="color: white">Add Super Admin User</a></button>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="ms-card">
                <div class="ms-card-body">

                    <table  id="myTables" class="display myTables" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
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
         dom: 'Bfrtip',
          buttons: [
        'excelHtml5'
             ],
          processing: true,
          serverSide: true,
          ajax: "{{ route('superadmin.admincreate.index') }}",

          columns: [
              {data: 'id', name: 'id'},
              {data: 'firstname', name: 'firstname'},
              {data: 'lastname', name: 'lastname'},
              {data: 'username', name: 'username'},
              {data: 'email', name: 'email'},
              {data: 'status', name: 'status'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      var excel_btn = document.querySelector('.buttons-excel span');
     excel_btn.innerHTML=`Export <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
     <path d="M4 16L4 17C4 18.6569 5.34315 20 7 20L17 20C18.6569 20 20 18.6569 20 17L20 16M16 8L12 4M12 4L8 8M12 4L12 16" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
     </svg>
     `
     var search_input = document.querySelectorAll('.dataTables_filter input');
      search_input.forEach(Element => {
        Element.placeholder = 'Search by name';
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
