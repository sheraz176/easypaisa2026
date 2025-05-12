@extends('operations.layouts.app')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">
        <!-- [Invoices Awaiting Payment] start -->

        <!-- [Invoices Awaiting Payment] end -->
        <!-- [Converted Leads] start -->
        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-cast"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">  <h5>{{ $refundCount }}</h5>
                                  </div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Refunds</h3>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-cast"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">  <h5>{{ $illustrationCount }}</h5>
                                  </div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Total illustration Count</h3>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>





        <!--! END: [Team Progress] !-->
    </div>
</div>

@endsection

@push('scripts')

@endpush
