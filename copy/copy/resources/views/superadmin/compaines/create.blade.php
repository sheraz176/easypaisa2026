@extends('superadmin.layouts.app')

@section('title')
    <title>Company</title>
@endsection

@push('styles')
<style>
    .select2-selection__choice {
        padding-right: 30px !important; /* Add padding to the right to avoid overlap */
        display: flex;
        align-items: center;
    }

    .select2-selection__choice__remove {
        position: relative;
        right: 0;
        margin-left: 5px; /* Add space between the text and the 'x' icon */
        cursor: pointer;
    }
</style>

@endpush


@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-xl-12">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <form action="{{ route('superadmin.compaines.store') }}" method="POST" class="needs-validation"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                   <label class="form-label">Package Assigned</label>
                                        <select class="form-select form-control"  data-select2-selector="tag" name="package_assigned[]" id="package_assigned" multiple>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}" data-bg="bg-primary">{{ $package->package_name }}</option>
                                            @endforeach
                                        </select>
                                </div>

                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter Company Name" required>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" id="address" class="form-control" placeholder="Enter Address" required></textarea>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" name="contact_number" id="contact_number" class="form-control"
                                        placeholder="Enter Contact Number" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Registration Number <span class="text-danger">*</span></label>
                                    <input type="text" name="registration_number" id="registration_number"
                                        class="form-control" placeholder="Enter Registration Number" required>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">NTN <span class="text-danger">*</span></label>
                                    <input type="text" name="ntn" id="ntn" class="form-control"
                                        placeholder="Enter NTN" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">SECP Registration</label>
                                    <input type="text" name="secp_registration" id="secp_registration"
                                        class="form-control" placeholder="Enter SECP Registration">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Business Type <span class="text-danger">*</span></label>
                                    <input type="text" name="business_type" id="business_type" class="form-control"
                                        placeholder="Enter Business Type" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Authorized Capital</label>
                                    <input type="number" name="authorized_capital" id="authorized_capital"
                                        class="form-control" placeholder="Enter Authorized Capital">
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Registration Date <span class="text-danger">*</span></label>
                                    <input type="date" name="registration_date" id="registration_date"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 text-end">
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
        document.getElementById('togglePassword').addEventListener('click', function(e) {
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
    <script src="{{ asset('admin/assets/js/calendar.js') }}"></script>
    <!-- Page Specific Scripts Start -->
    <script src="{{ asset('admin/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/moment.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.webticker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/index-chart.js') }}"></script>




@endpush
