@extends('superadmin.layouts.app')

@section('title')
    <title>Kibor Rates</title>
@endsection

@section('content')


<div class="main-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <form action="{{ route('superadmin.KiborRates.store') }}" method="POST" class="needs-validation">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="effective_date" class="form-label">Effective Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="effective_date" name="effective_date" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="kibor_rate" class="form-label">KIBOR Rate (%) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="kibor_rate" name="kibor_rate" step="0.01" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary ">Save</button>
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
