@extends('superadmin..layouts.app')

@section('title')
    <title>Users</title>
@endsection

@section('content')
<div class="col-12">
    <div class="card stretch stretch-full">
        <div class="card-body">
            <form action="{{ route('superadmin.users.update') }}" method="POST" class="needs-validation" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="id" class="form-control" value="{{ $user->id }}" required>

                <div class="form-group row">
                    <label for="username" class="col-md-2 col-form-label">User Name</label>
                    <div class="col-md-10">
                        <input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}" style="text-transform: capitalize;" required>
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label for="password" class="col-md-2 col-form-label">Update Password</label>
                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Update Password">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label for="is_active" class="col-md-2 col-form-label">User Status</label>
                    <div class="col-md-10">
                        <select class="form-control" name="is_active" id="is_active" required>
                            <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>User Active</option>
                            <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>User Inactive</option>
                        </select>
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <label for="role" class="col-md-2 col-form-label">Assign Role</label>
                    <div class="col-md-10">
                        <select class="form-control" name="role" id="role" required>
                            <option value="accounts" {{ $user->role == 'accounts' ? 'selected' : '' }}>Accounts</option>
                            <option value="investment" {{ $user->role == 'investment' ? 'selected' : '' }}>Investment</option>
                            <option value="operations" {{ $user->role == 'operations' ? 'selected' : '' }}>Operations</option>
                        </select>
                    </div>
                </div>
                <br>

                <div class="form-group row">
                    <div class="col-md-10 offset-md-2 text-end">
                        <button class="btn btn-primary btn-sm" type="submit">Update</button>
                    </div>
                </div>
            </form>
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
