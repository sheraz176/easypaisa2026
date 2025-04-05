

<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{route('superadmin.dashboard')}}" class="b-brand">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo logo-lg" />
                <img src="{{ asset('assets/images/logo.png') }}" alt="" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Navigation</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-home"></i></span>
                        <span class="nxl-mtext">Dashboards</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/dashboard*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.dashboard')}}">Home</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Manage Users</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.index')}}">Users List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.create')}}">Add Users</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-briefcase"></i></span>
                        <span class="nxl-mtext">Manage Companies</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/compaines/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.compaines.index')}}">Companies List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/compaines/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.compaines.create')}}">Add Companies</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-package"></i></span>
                        <span class="nxl-mtext">Manage Packages</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/Packages/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Packages.index')}}">Packages List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/Packages/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Packages.create')}}">Add Packages</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/active/Packages/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.active.Packages.index')}}">Active Packages</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-layers"></i></span>
                        <span class="nxl-mtext">Manage Slabs</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/Slabs/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Slabs.index')}}">Slabs List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/Slabs/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Slabs.create')}}">Add Slabs</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-trending-up"></i></span>
                        <span class="nxl-mtext">Kibor Rates</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/KiborRates/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.KiborRates.index')}}">Kibor Rates List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/KiborRates/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.KiborRates.create')}}">Add Kibor Rates</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-refresh-ccw"></i></span>
                        <span class="nxl-mtext">Refund Customers</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/RefundCustomer/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.RefundCustomer.index')}}">Refund Customers List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/RefundCustomer/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.RefundCustomer.create')}}">Add Refund Customer</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-calendar"></i></span>
                        <span class="nxl-mtext">Manage Calendar</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/Calender/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Calender.index')}}">Calendar List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/Calender/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.Calender.create')}}">Add Calendar</a>
                        </li>
                    </ul>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-heart"></i></span>
                        <span class="nxl-mtext">Insurance Benefits</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ Request::is('super-admin/insurancebenefits/index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.insurancebenefits.index')}}">Insurance Benefits List</a>
                        </li>
                        <li class="nxl-item {{ Request::is('super-admin/insurancebenefits/create*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('superadmin.insurancebenefits.create')}}">Add Insurance Benefits</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</nav>
