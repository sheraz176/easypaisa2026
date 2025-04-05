@extends('superadmin.layouts.app')

@section('title')
    <title>Super Admin Users</title>
@endsection

@section('content')
<div class="ms-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb pl-0">
                    <li class="breadcrumb-item"><a href="{{route('superadmin.dashboard')}}"><i class="material-icons">home</i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('superadmin.admincreate.index')}}">Super Admin User List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Super Admin User</li>
                </ol>
            </nav>
        </div>
        <div class="modal-body p-0 text-left">
            <div class="col-xl-12 col-md-12">
                @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif
            @if ($errors->any())
           <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
            @endforeach
             </ul>
           </div>
          @endif
                <div class="ms-panel ms-panel-bshadow-none">
                    <div class="ms-panel-header">
                        <h6>Super Admin Information</h6>
                    </div>
                    <div class="ms-panel-body">
                        <form action="{{ route('superadmin.adminstore.stores') }}" method="POST" class="needs-validation"  enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom09">First Name</label>
                                    <div class="input-group">
                                        <input type="text" name="firstname" id="firstname" class="form-control"
                                            placeholder="Enter Fast Name" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom09">Last Name</label>
                                    <div class="input-group">
                                        <input type="text" name="lastname" id="lastname" class="form-control"
                                            placeholder="Enter Last Name" required>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="validationCustom11">Email</label>
                                    <div class="input-group">
                                        <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Enter Email" required>

                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom12">User Name </label>
                                    <div class="input-group">
                                        <input type="text" name="username" id="username" class="form-control"
                                        placeholder="Enter User Name" required>

                                    </div>

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom13">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fa fa-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-danger mt-4 d-inline w-20" type="submit">Submit</button>
                        </form>
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
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        // toggle the type attribute
        const passwordField = document.getElementById('password');
        const passwordFieldType = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', passwordFieldType);

        // toggle the eye icon
        const eyeIcon = document.getElementById('eyeIcon');
        if (passwordFieldType === 'password') {
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    });
    </script>
<script src="{{asset('admin/assets/js/calendar.js')}}"></script>
 <!-- Page Specific Scripts Start -->
 <script src="{{asset('admin/assets/js/slick.min.js')}}"> </script>
 <script src="{{asset('admin/assets/js/moment.js')}}"> </script>
 <script src="{{asset('admin/assets/js/jquery.webticker.min.js')}}"> </script>
 <script src="{{asset('admin/assets/js/Chart.bundle.min.js')}}"> </script>
 <script src="{{asset('admin/assets/js/index-chart.js')}}"> </script>
@endpush
