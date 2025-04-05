@extends('superadmin..layouts.app')

@section('title')
    <title>Users</title>
@endsection

@section('content')
<div class="main-content">
    <div class="row">

<div class="col-12">
    <div class="card stretch stretch-full">
        <div class="card-body">
            <form action="{{ route('superadmin.users.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                @csrf
                <!-- First Row: First Name and Last Name -->
                <div class="form-group row mb-4">
                    <div class="col-md-6">
                        <label for="first_name" class="col-form-label">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Enter First Name" style="text-transform: capitalize;" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="col-form-label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" style="text-transform: capitalize;" required>
                    </div>
                </div>

                <!-- Second Row: Email and Username -->
                <div class="form-group row mb-4">
                    <div class="col-md-6">
                        <label for="email" class="col-form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="username" class="col-form-label">User Name</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter User Name" style="text-transform: capitalize;" required>
                    </div>
                </div>

                <!-- Third Row: Password and Phone Number -->
                <div class="form-group row mb-4">
                    <div class="col-md-6">
                        <label for="password" class="col-form-label">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                        <input type="number" name="phone_number" id="phone_number" class="form-control" placeholder="Enter Phone Number" required>
                    </div>
                </div>

                <!-- Fourth Row: Role -->
                <div class="form-group row mb-4">
                    <div class="col-md-6">
                        <label for="role" class="col-form-label">Assign Role</label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="accounts">Accounts</option>
                            <option value="investment">Investment</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group row">
                    <div class="col-md-10 offset-md-2 text-end">
                        <button class="btn btn-primary " type="submit">Submit</button>
                    </div>
                </div>
            </form>
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
