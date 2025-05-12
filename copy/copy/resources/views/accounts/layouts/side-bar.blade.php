

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{route('accounts.dashboards')}}" class="b-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo logo-lg" />
                <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>

                <!-- Dashboards -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Dashboards</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/dashboards*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('accounts.dashboards')}}">Home</a>
                        </li>
                    </ul>
                </li>

                <!-- Investment -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-dollar-sign"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Investment</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/InvestmentLedger*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.InvestmentLedger')}}">Investment Ledger Saving</a>
                        </li>
                    </ul>
                </li>

                <!-- Insurance -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-shield"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Insurance</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/InsuranceData*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.InsuranceData')}}">Insurance Data</a>
                        </li>
                    </ul>
                </li>

                <!-- Beneficiaries -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Beneficiaries</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/Beneficiary*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.Beneficiary')}}">Beneficiary</a>
                        </li>
                    </ul>
                </li>

                <!-- Customer Saving -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-save"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Customer Saving</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/CustomerSavingsMaster*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.CustomerSavingsMaster')}}">Customer Saving Master </a>
                        </li>
                    </ul>
                </li>

                <!-- Daily Return -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-bar-chart"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Daily Return</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/DailyReturn*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.DailyReturn')}}">Daily Return </a>
                        </li>
                    </ul>
                </li>

                <!-- Search Customer -->
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-search"></i></span> <!-- Changed Icon -->
                        <span class="nxl-mtext">Search Customer</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/accounts/SearchForm*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('account.SearchForm')}}">Search</a>
                        </li>
                    </ul>
                </li>
            </ul>


        </div>
    </div>
</nav>
