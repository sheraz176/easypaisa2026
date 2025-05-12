@extends('superadmin.layouts.app')

@section('title')
    <title>Refund Customer</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">
        <div class="col-xl-12">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <form action="{{ route('superadmin.RefundCustomer.store') }}" method="POST" class="needs-validation">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="investment_master_id" class="form-label">Investment Master <span class="text-danger">*</span></label>
                                <select class="form-control" id="investment_master_id" name="investment_master_id" required>
                                    @foreach(\App\Models\investmentmaster::all() as $investmentMaster)
                                        <option value="{{ $investmentMaster->id }}">{{ $investmentMaster->customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="refund_amount" class="form-label">Refund Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="refund_amount" name="refund_amount" step="0.01" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="refund_request_date" class="form-label">Refund Request Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="refund_request_date" name="refund_request_date" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="refund_processed_date" class="form-label">Refund Processed Date</label>
                                <input type="date" class="form-control" id="refund_processed_date" name="refund_processed_date">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="processing_fee_deducted" class="form-label">Processing Fee Deducted <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="processing_fee_deducted" name="processing_fee_deducted" step="0.01" required>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="processed">Processed</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="partial">Partial</option>
                                    <option value="full">Full</option>
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
