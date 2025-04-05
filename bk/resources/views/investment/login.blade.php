<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="Sheraz">

    <title>EasyPaisa || Login investment</title>

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
                        <p class="fs-12 fw-medium text-muted">Thank you for get back <strong>investment</strong>, let's access our the best recommendation for you.</p>
                        @if(session('status'))
                        <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(session('error'))
                        <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                      @if($errors->has('login'))
                      <div class="alert alert-danger">
                          {{ $errors->first('login') }}
                      </div>
                      @endif

                      <form id="formAuthentication" class="mb-3" action="{{ route('investment.loginform') }}" method="post">
                        @csrf
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="Username"  id="username"
                                name="username"  required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control"   name="password" id="password" placeholder="Password"  required>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="rememberMe">
                                        <label class="custom-control-label c-pointer" for="rememberMe">Remember Me</label>
                                    </div>
                                </div>
                                <div>
                                    <a href="#" class="fs-11 text-primary">Forget password?</a>
                                </div>
                            </div>
                            <div class="mt-5">
                                <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                            </div>
                        </form>

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
