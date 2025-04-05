@extends('superadmin.layouts.app')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')

<div class="main-content">
    <div class="row">

        <div class="col-xxl-6 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-package"></i> <!-- Package Icon -->
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    <span id="packagesCount">0</span> <!-- Total Packages Count -->
                                </div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Packages</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="">
                            <i class="feather-more-vertical"></i>
                        </a>
                    </div>
                    <div class="pt-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">Packages Overview</a>
                            <div class="w-100 text-end">
                                <span class="fs-12 text-dark">100%</span>
                                <span class="fs-11 text-muted">(Active)</span>
                            </div>
                        </div>
                        <div class="progress mt-2 ht-3">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-md-6">
            <div class="card stretch stretch-full">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="d-flex gap-4 align-items-center">
                            <div class="avatar-text avatar-lg bg-gray-200">
                                <i class="feather-layers"></i> <!-- Slabs Icon -->
                            </div>
                            <div>
                                <div class="fs-4 fw-bold text-dark">
                                    <span id="slabsCount">0</span> <!-- Total Slabs Count -->
                                </div>
                                <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Slabs</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="">
                            <i class="feather-more-vertical"></i>
                        </a>
                    </div>
                    <div class="pt-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-12 fw-medium text-muted text-truncate-1-line">Slabs Overview</a>
                            <div class="w-100 text-end">
                                <span class="fs-12 text-dark">N/A</span>
                            </div>
                        </div>
                        <div class="progress mt-2 ht-3">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- KIBOR Rates -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-bar-chart-2"></i> <!-- KIBOR Icon -->
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">
                                        <span id="kiborRatesCount">0</span>
                                    </div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">KIBOR Rates</h3>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund Cases -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-refresh-ccw"></i> <!-- Refund Icon -->
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">
                                        <span id="refundCasesCount">0</span>
                                    </div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Refund Cases</h3>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Holidays -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-calendar"></i> <!-- Holiday Icon -->
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">
                                        <span id="holidaysCount">0</span>
                                    </div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Holidays</h3>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Insurance Benefits -->
            <div class="col-xxl-3 col-md-6">
                <div class="card stretch stretch-full">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-gray-200">
                                    <i class="feather-shield"></i> <!-- Insurance Icon -->
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">
                                        <span id="insuranceBenefitsCount">0</span>
                                    </div>
                                    <h3 class="fs-13 fw-semibold text-truncate-1-line">Insurance Benefits</h3>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="">
                                <i class="feather-more-vertical"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <!-- Accounts Users -->
            <div class="col-lg-4">
                <div class="card mb-4 stretch stretch-full">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="avatar-text">
                                <i class="feather feather-user"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Accounts Users</div>
                                <div class="fs-12 text-muted">Accounts Section</div>
                            </div>
                        </div>
                        <div class="fs-4 fw-bold text-dark" id="accountsUsersCount">0</div>
                    </div>
                </div>
            </div>

            <!-- Investment Users -->
            <div class="col-lg-4">
                <div class="card mb-4 stretch stretch-full">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="avatar-text">
                                <i class="feather feather-briefcase"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Investment Users</div>
                                <div class="fs-12 text-muted">Investment Section</div>
                            </div>
                        </div>
                        <div class="fs-4 fw-bold text-dark" id="investmentUsersCount">0</div>
                    </div>
                </div>
            </div>

            <!-- Operations Users -->
            <div class="col-lg-4">
                <div class="card mb-4 stretch stretch-full">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <div class="avatar-text">
                                <i class="feather feather-settings"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">Operations Users</div>
                                <div class="fs-12 text-muted">Operations Section</div>
                            </div>
                        </div>
                        <div class="fs-4 fw-bold text-dark" id="operationsUsersCount">0</div>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div class="col-xxl-4">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Leads Overview</h5>
                    <div class="card-header-action">
                        <div class="card-header-btn">
                            <div data-bs-toggle="tooltip" title="Delete">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Refresh">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                <div data-bs-toggle="tooltip" title="Options">
                                    <i class="feather-more-vertical"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-at-sign"></i>New</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-calendar"></i>Event</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-bell"></i>Snoozed</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-trash-2"></i>Deleted</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-settings"></i>Settings</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-life-buoy"></i>Tips & Tricks</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body custom-card-action">
                    <div id="leads-overview-donut"></div>
                    <div class="row g-2">
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #1cb25c"></span>
                                <span>New<span class="fs-10 text-muted ms-1">(20K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #0d519e"></span>
                                <span>Contacted<span class="fs-10 text-muted ms-1">(15K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #1976d2"></span>
                                <span>Qualified<span class="fs-10 text-muted ms-1">(10K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #1e88e5"></span>
                                <span>Working<span class="fs-10 text-muted ms-1">(18K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #2196f3"></span>
                                <span>Customer<span class="fs-10 text-muted ms-1">(10K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #42a5f5"></span>
                                <span>Proposal<span class="fs-10 text-muted ms-1">(15K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #64b5f6"></span>
                                <span>Leads<span class="fs-10 text-muted ms-1">(16K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #90caf9"></span>
                                <span>Progress<span class="fs-10 text-muted ms-1">(14K)</span></span>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0);" class="p-2 hstack gap-2 rounded border border-dashed border-gray-5">
                                <span class="wd-7 ht-7 rounded-circle d-inline-block" style="background-color: #aad6fa"></span>
                                <span>Others<span class="fs-10 text-muted ms-1">(10K)</span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-8">
            <div class="card stretch stretch-full">
                <div class="card-header">
                    <h5 class="card-title">Latest Leads</h5>
                    <div class="card-header-action">
                        <div class="card-header-btn">
                            <div data-bs-toggle="tooltip" title="Delete">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-danger" data-bs-toggle="remove"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Refresh">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning" data-bs-toggle="refresh"> </a>
                            </div>
                            <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success" data-bs-toggle="expand"> </a>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-sm" data-bs-toggle="dropdown" data-bs-offset="25, 25">
                                <div data-bs-toggle="tooltip" title="Options">
                                    <i class="feather-more-vertical"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-at-sign"></i>New</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-calendar"></i>Event</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-bell"></i>Snoozed</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-trash-2"></i>Deleted</a>
                                <div class="dropdown-divider"></div>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-settings"></i>Settings</a>
                                <a href="javascript:void(0);" class="dropdown-item"><i class="feather-life-buoy"></i>Tips & Tricks</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body custom-card-action p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="border-b">
                                    <th scope="row">Users</th>
                                    <th>Proposal</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-image">
                                                <img src="./../assets/images/avatar/2.png" alt="" class="img-fluid" />
                                            </div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block">Archie Cantones</span>
                                                <span class="fs-12 d-block fw-normal text-muted">arcie.tones@gmail.com</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-gray-200 text-dark">Sent</span>
                                    </td>
                                    <td>11/06/2023 10:53</td>
                                    <td>
                                        <span class="badge bg-soft-success text-success">Completed</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-image">
                                                <img src="./../assets/images/avatar/3.png" alt="" class="img-fluid" />
                                            </div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block">Holmes Cherryman</span>
                                                <span class="fs-12 d-block fw-normal text-muted">golms.chan@gmail.com</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-gray-200 text-dark">New</span>
                                    </td>
                                    <td>11/06/2023 10:53</td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary">In Progress </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-image">
                                                <img src="./../assets/images/avatar/4.png" alt="" class="img-fluid" />
                                            </div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block">Malanie Hanvey</span>
                                                <span class="fs-12 d-block fw-normal text-muted">lanie.nveyn@gmail.com</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-gray-200 text-dark">Sent</span>
                                    </td>
                                    <td>11/06/2023 10:53</td>
                                    <td>
                                        <span class="badge bg-soft-success text-success">Completed</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-image">
                                                <img src="./../assets/images/avatar/5.png" alt="" class="img-fluid" />
                                            </div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block">Kenneth Hune</span>
                                                <span class="fs-12 d-block fw-normal text-muted">nneth.une@gmail.com</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-gray-200 text-dark">Returning</span>
                                    </td>
                                    <td>11/06/2023 10:53</td>
                                    <td>
                                        <span class="badge bg-soft-warning text-warning">Not Interested</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-image">
                                                <img src="./../assets/images/avatar/6.png" alt="" class="img-fluid" />
                                            </div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block">Valentine Maton</span>
                                                <span class="fs-12 d-block fw-normal text-muted">alenine.aton@gmail.com</span>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-gray-200 text-dark">Sent</span>
                                    </td>
                                    <td>11/06/2023 10:53</td>
                                    <td>
                                        <span class="badge bg-soft-success text-success">Completed</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <ul class="list-unstyled d-flex align-items-center gap-2 mb-0 pagination-common-style">
                        <li>
                            <a href="javascript:void(0);"><i class="bi bi-arrow-left"></i></a>
                        </li>
                        <li><a href="javascript:void(0);" class="active">1</a></li>
                        <li><a href="javascript:void(0);">2</a></li>
                        <li>
                            <a href="javascript:void(0);"><i class="bi bi-dot"></i></a>
                        </li>
                        <li><a href="javascript:void(0);">8</a></li>
                        <li><a href="javascript:void(0);">9</a></li>
                        <li>
                            <a href="javascript:void(0);"><i class="bi bi-arrow-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}

    </div>
</div>





@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetchCounts();

        function fetchCounts() {
            $.ajax({
                url: "{{ route('dashboard.counts') }}",
                method: "GET",
                success: function (response) {
                    // Update the counts on the dashboard
                    $('#packagesCount').text(response.packages_count);
                    $('#slabsCount').text(response.slabs_count);
                    $('#kiborRatesCount').text(response.kibor_rates_count);
                    $('#refundCasesCount').text(response.refund_cases_count);
                    $('#holidaysCount').text(response.holidays_count);
                    $('#insuranceBenefitsCount').text(response.insurance_benefits_count);
                },
                error: function (xhr) {
                    console.error("Error fetching counts:", xhr);
                }
            });
        }
    });
</script>

@endpush
