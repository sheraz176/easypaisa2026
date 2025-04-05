@extends('superadmin.layouts.app')

@section('title')
    <title>Insurance Benefit</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <form method="POST" action="{{ route('superadmin.insurancebenefits.store') }}" class="needs-validation">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="package_id" class="form-label">Package <span class="text-danger">*</span></label>
                                <select class="form-control" id="package_id" name="package_id" required>
                                    <option value="" disabled selected>Select a Package</option>
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->package_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="benefit_type" class="form-label">Benefit Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="benefit_type" name="benefit_type" required>
                                    <option value="health">Health</option>
                                    <option value="life">Life</option>
                                    <option value="accidental">Accidental</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="benefit_name" class="form-label">Benefit Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="benefit_name" name="benefit_name" placeholder="Enter Benefit Name" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" placeholder="Enter Amount" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <label for="benefit_description" class="form-label">Benefit Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="benefit_description" name="benefit_description" placeholder="Enter Benefit Description" rows="4" required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary">Add Benefit</button>
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
