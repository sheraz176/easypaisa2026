@extends('superadmin.layouts.app')

@section('title')
    <title>Active Packages</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">

        @foreach($packages as $package)
        <div class="col-xxl-6 col-md-6">
            <!-- Make the entire box clickable by wrapping it in an anchor tag -->
            <a href="{{ route('superadmin.active.Packages.show', $package->id) }}" class="text-decoration-none">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <p class="fs-11 fw-semibold text-uppercase text-muted">{{ $package->type }}</p>
                        <h4><span class="counter">{{ $package->duration_breakage_days }} Days</span></h4>
                        <div class="hstack gap-2 mt-3">
                            <span class="fs-11 text-success badge bg-gray-100">
                                <i class="feather-trending-up fs-12 me-1"></i>
                                <span>Rs {{ $package->processing_fee }}</span>
                            </span>
                            <span class="fs-11 text-muted">Processing Fees</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-muted">Package: {{ $package->package_name }}</p>
                            <p class="text-muted">Created At: {{ \Carbon\Carbon::parse($package->created_at)->format('Y-m-d H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach




    </div>
</div>



@endsection

@push('scripts')

@endpush
