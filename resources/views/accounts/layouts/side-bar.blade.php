

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
                <li class="nxl-item nxl-hasmenu">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Dashboards</span><span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item  {{ Request::is('accounts/dashboards*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{route('accounts.dashboards')}}">Home</a></li>

                    </ul>
                </li>







            </ul>

        </div>
    </div>
</nav>
