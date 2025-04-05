@extends('superadmin.layouts.app')

@section('title')
    <title>Packages</title>
@endsection

@section('content')


<div class="main-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <form action="{{ route('superadmin.Packages.store') }}" method="POST" class="needs-validation">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="package_name" class="form-label">Package Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="package_name" name="package_name" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="conventional">Conventional</option>
                                    <option value="islamic">Islamic</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="min_duration_days" class="form-label">Min Duration (Days) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="min_duration_days" name="min_duration_days" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="max_duration_days" class="form-label">Max Duration (Days) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_duration_days" name="max_duration_days" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="duration_breakage_days" class="form-label">Breakage Days</label>
                                <input type="number" class="form-control" id="duration_breakage_days" name="duration_breakage_days">
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="processing_fee" class="form-label">Processing Fee <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="processing_fee" name="processing_fee" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary ">Save Package</button>
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
