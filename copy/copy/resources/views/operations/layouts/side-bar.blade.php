<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('operations.dashboards') }}" class="b-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo logo-lg" />
                <img src="{{ asset('assets/images/sm-ep.jpg') }}" alt="Small Logo" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                {{-- Dashboards --}}
                @php
                    $dashboardActive = Request::is('super-admin/dashboards');
                @endphp
                <li class="nxl-item nxl-hasmenu {{ $dashboardActive ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboards</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu {{ $dashboardActive ? 'show' : '' }}">
                        <li class="nxl-item {{ $dashboardActive ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('operations.dashboards') }}">Analytics Dashboard</a>
                        </li>
                    </ul>
                </li>

                {{-- Operations Reports --}}
                @php
                    $refundActive = Request::is('super-admin/operation/RefundReport');
                    $illustrationActive = Request::is('super-admin/operation/illustrationReport');
                    $operationsActive = $refundActive || $illustrationActive;
                @endphp
                <li class="nxl-item nxl-hasmenu {{ $operationsActive ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-file-text"></i></span>
                        <span class="nxl-mtext">Operations Reports</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu {{ $operationsActive ? 'show' : '' }}">
                        <li class="nxl-item {{ $refundActive ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('operation.RefundReport') }}">Zakat Withdrawal Requests</a>
                        </li>
                        <li class="nxl-item {{ $illustrationActive ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('operation.illustrationReport') }}">Customer Illustrations Report</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
