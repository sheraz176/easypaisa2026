
<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="Sheraz">

    <title>EasyPaisa || Login Operations (Zakat)</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-abbr.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/theme.min.css') }}">

</head>

<body>
    <div>
         
     </div>
    <main class="auth-creative-wrapper">
    
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
            
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    
                    <div class="row flex-1 g-0">
                    
                        <div class="col-lg-6 h-100 my-auto">
                            
                            <div class="creative-card-body card-body p-sm-5 text-center d-flex flex-column align-items-center">
                                
                            <img src="{{ asset('assets/images/logo-abbr.png') }}" alt="Logo" class="mb-4" style="max-width: 250px;">
                        
                                  <h4 class="fs-13 fw-bold mb-2">Operation (Zakat Handling) for Easypaisa Digital Saving</h4>
                                    <p class="fs-12 fw-medium text-muted">Thank you for get back <strong>accounts</strong>, let's access our the best recommendation for you.</p>
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

                               <form class="w-100 mt-4 pt-2" action="{{ route('operations.loginform') }}" method="post">
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
                                           <a href="#" class="fs-11">Forget password?</a>
                                       </div>
                                   </div>
                                   <div class="mt-5">
                                       <button type="submit" class="btn btn-lg btn-primary w-100">Login</button>
                                   </div>
                               </form>

                            </div>
                        </div>
                        <div class="col-lg-6 bg-primary">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="{{ asset('assets/images/login-page.png') }}" alt="" class="img-fluid">
                            </div>
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
