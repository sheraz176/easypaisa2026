<!doctype html>
<html lang="en" dir="ltr">

<head>
    @include('investment.layouts.meta')
    @include('investment.layouts.style')

</head>

<body>

    @include('investment.layouts.side-bar')
    @include('investment.layouts.header')

    <main class="nxl-container">
        <div class="nxl-content">
            @include('investment.layouts.mainheader')
                @yield('content')
        </div>
        <!-- [ Footer ] start -->
        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>easypaisa @Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
        <!-- [ Footer ] end -->
    </main>


    @include('investment.layouts.script')

</body>

</html>
