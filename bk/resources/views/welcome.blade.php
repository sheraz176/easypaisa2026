



<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="Sheraz">

    <title>EasyPaisa || Login </title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-abbr.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">

</head>

<body>

    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative">
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
                        <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="" class="img-fluid" style="height: 100%">
                    </div>
                    <div class="card-body p-sm-5">
                        <h2 class="fs-20 fw-bolder mb-4">Login</h2>
                        <h4 class="fs-13 fw-bold mb-2">Login to your account</h4>
                        <p class="fs-12 fw-medium text-muted">Thank you for get back ,let's access our the best recommendation for you.</p>


                        <div class="dropdown">
                            <button class="btn btn-lg btn-primary w-100 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Select Role
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('superadmin.login') }}">Super Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('accounts.login') }}">Accounts</a></li>
                                <li><a class="dropdown-item" href="{{ route('investment.login') }}">Investment</a></li>
                                <li><a class="dropdown-item" href="{{ route('operations.login') }}">Operations</a></li>
                            </ul>
                        </div>



                        {{-- <div class="mt-5 text-muted">
                            <span> Don't have an account?</span>
                            <a href="#" class="fw-bold">Create an Account</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>



    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>

</body>

</html>

