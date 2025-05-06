<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="Sheraz">

    <title>EasyPaisa || Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-abbr.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">

    <style>
        .role-card {
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            transition: 0.3s;
            cursor: pointer;
            background-color: #f8f9fa;
        }

        .role-card:hover {
            background-color: #e9ecef;
        }

        .role-card img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .role-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <main class="auth-minimal-wrapper">
        <div class="auth-minimal-inner">
            <div class="minimal-card-wrapper">
                <div class="card p-sm-5 text-center d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="Logo" class="mb-4" style="max-width: 250px;">
                    <div class="card-body p-sm-2">
                        <h4 class="fs-17 mb-2 fw-medium text-muted">Select Your Role Provided by Business Operation Team</h4>
                        <p class="fs-11 fw-medium text-muted">Contact IT for information if you are unsure about your role.</p>

                        <div class="role-container">
                            <a href="{{ route('superadmin.login') }}" class="role-card text-decoration-none text-dark">
                                <img src="{{ asset('assets/images/admin.png') }}" alt="Super Admin">
                                <h6>Super Admin</h6>
                            </a>

                            <a href="{{ route('accounts.login') }}" class="role-card text-decoration-none text-dark">
                                <img src="{{ asset('assets/images/accountant.png') }}" alt="Accounts">
                                <h6>Accounts</h6>
                            </a>

                            <a href="{{ route('investment.login') }}" class="role-card text-decoration-none text-dark">
                                <img src="{{ asset('assets/images/saving.png') }}" alt="Investment">
                                <h6>Investment</h6>
                            </a>

                            <a href="{{ route('operations.login') }}" class="role-card text-decoration-none text-dark">
                                <img src="{{ asset('assets/images/operational-system.png') }}" alt="Operations">
                                <h6>Operations</h6>
                            </a>
                        </div>

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
