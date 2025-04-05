@extends('superadmin.layouts.app')

@section('title')
    <title>Active Packages</title>
@endsection

@section('content')


    <!-- [ Main Content ] start -->
    <div class="main-content">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="proposalTab">
                <div class="row">


                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body">
                                <h4 class="fw-bold mb-4">Package Details</h4>
                                <div class="row">
                                    <!-- Left side (4 fields) -->
                                    <div class="col-md-6">
                                        <div class="fs-13 text-muted lh-lg">
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Package Name:</span>
                                                <span>{{ $package->package_name }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Type:</span>
                                                <span>{{ $package->type }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Minimum Duration (Days):</span>
                                                <span>{{ $package->min_duration_days }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Maximum Duration (Days):</span>
                                                <span>{{ $package->max_duration_days }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Right side (3 fields) -->
                                    <div class="col-md-6">
                                        <div class="fs-13 text-muted lh-lg">
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Breakage Duration (Days):</span>
                                                <span>{{ $package->duration_breakage_days }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Processing Fee:</span>
                                                <span>Rs {{ $package->processing_fee }}</span>
                                            </div>
                                            <div>
                                                <span class="fw-semibold text-dark border-bottom border-bottom-dashed">Created At:</span>
                                                <span>{{ \Carbon\Carbon::parse($package->created_at)->format('Y-m-d H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Slabs</h5>
                                <a href="{{route('superadmin.Slabs.create')}}" class="btn btn-md btn-light-brand">
                                    <i class="feather-plus me-2"></i>
                                    <span>New Slabs</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="row">
                                        @foreach($Slabs as $slab)
                                            <div class="col-xxl-4 col-md-6">
                                                <div class="card stretch stretch-full">
                                                    <div class="card-body">
                                                        <div class="avatar-text rounded-2 mb-4">
                                                            <i class="feather-archive"></i>
                                                        </div>
                                                        <h6 class="fw-bold mb-3 text-truncate-1-line">{{ $slab->slab_name }}</h6>
                                                        <p class="text-muted mb-4 text-truncate-3-line">
                                                            Initial Deposit: Rs {{ $slab->initial_deposit }}<br>
                                                            Maximum Deposit: Rs {{ $slab->maximum_deposit }}<br>
                                                            Daily Return Rate: {{ $slab->daily_return_rate }}%
                                                        </p>
                                                        <p class="text-muted mb-4">Created At: {{ \Carbon\Carbon::parse($slab->created_at)->format('Y-m-d H:i:s') }}</p>
                                                    </div>
                                                </div>
                                            </div>






                                        @endforeach
                                    </div> --}}

                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="kiborRatesTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Slabs</th>
                                                        <th>Policy Rate</th>
                                                        <th>Customer%</th>
                                                        <th>EP%</th>
                                                        <th>EFUL%</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Slabs as $slab)
                                                        @php
                                                            $policyRate = 11; // Default policy rate
                                                            $customerPercent = 0;
                                                            $epPercent = 0;
                                                            $efulPercent = 1;

                                                            if ($slab->initial_deposit >= 2000 && $slab->maximum_deposit <= 9999) {
                                                                $customerPercent = 4;
                                                                $epPercent = 6;
                                                            } elseif ($slab->initial_deposit >= 10000 && $slab->maximum_deposit <= 49999) {
                                                                $customerPercent = 5;
                                                                $epPercent = 5;
                                                            } elseif ($slab->initial_deposit >= 50000 && $slab->maximum_deposit <= 149999) {
                                                                $customerPercent = 6;
                                                                $epPercent = 4;
                                                            } elseif ($slab->initial_deposit >= 150000 && $slab->maximum_deposit <= 200000) {
                                                                $customerPercent = 7;
                                                                $epPercent = 3;
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td>{{ number_format($slab->initial_deposit, 2) }} - {{ number_format($slab->maximum_deposit, 2) }}</td>
                                                            <td>{{ $policyRate }}%</td>
                                                            <td>{{ $customerPercent }}%</td>
                                                            <td>{{ $epPercent }}%</td>
                                                            <td>{{ $efulPercent }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Insurance Benefits</h5>
                                <a href="{{route('superadmin.insurancebenefits.create')}}" class="btn btn-md btn-light-brand">
                                    <i class="feather-plus me-2"></i>
                                    <span>New InsuranceBenefit</span>
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="row">
                                            @foreach($InsuranceBenefit as $benefit)
                                                <div class="col-xxl-4 col-md-6">
                                                    <div class="card stretch stretch-full">
                                                        <div class="card-body">
                                                            <div class="avatar-text rounded-2 mb-4">
                                                                <i class="feather-shield"></i>  <!-- You can change the icon to match the benefit type -->
                                                            </div>
                                                            <h6 class="fw-bold mb-3 text-truncate-1-line">{{ $benefit->benefit_name }}</h6>
                                                            <p class="text-muted mb-4 text-truncate-3-line">
                                                                Benefit Type: {{ $benefit->benefit_type }}<br>
                                                                Description: {{ $benefit->benefit_description }}<br>
                                                                Amount: Rs {{ $benefit->amount }}
                                                            </p>
                                                            <p class="text-muted mb-4">Created At: {{ \Carbon\Carbon::parse($benefit->created_at)->format('Y-m-d H:i:s') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-header">
                                <h5 class="card-title">Companies</h5>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        @foreach($companies as $company)
                                            <div class="col-xxl-4 col-md-6">
                                                <div class="card stretch stretch-full">
                                                    <div class="card-body">
                                                        <div class="avatar-text rounded-2 mb-4">
                                                            <i class="feather-briefcase"></i> <!-- You can change the icon if needed -->
                                                        </div>
                                                        <h6 class="fw-bold mb-3">{{ $company->name }}</h6>
                                                        <p class="text-muted mb-4">
                                                            <strong>Address:</strong> {{ $company->address }}<br>
                                                            <strong>Contact Number:</strong> {{ $company->contact_number }}<br>
                                                            <strong>Registration Number:</strong> {{ $company->registration_number }}<br>
                                                            <strong>Business Type:</strong> {{ $company->business_type }}<br>
                                                            <strong>Registration Date:</strong> {{ \Carbon\Carbon::parse($company->registration_date)->format('Y-m-d') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>




@endsection

@push('scripts')

@endpush
