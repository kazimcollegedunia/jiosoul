<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8" />
        <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

        <!-- Site favicon -->
        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="{{asset('vendors/images/apple-touch-icon.png')}}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="{{asset('vendors/images/favicon-32x32.png')}}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{asset('vendors/images/favicon-16x16.png')}}"
        />

        <!-- Mobile Specific Metas -->
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1"
        />

        <!-- Google Font -->
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet"
        />
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/core.css')}}" />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{asset('vendors/styles/icon-font.min.css')}}"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="{{asset('src/plugins/jquery-steps/jquery.steps.css')}}"
        />
        <link rel="stylesheet" type="text/css" href="{{asset('vendors/styles/style.css')}}" />

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script
            async
            src="https://www.googletagmanager.com/gtag/js?id=G-GBZ3SGGX85"
        ></script>
        <script
            async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2973766580778258"
            crossorigin="anonymous"
        ></script>

        <!-- End Google Tag Manager -->
    </head>

    <body class="login-page">
        <div class="login-header box-shadow">
            <div
            class="container-fluid d-flex justify-content-between align-items-center"
            >
            <div class="brand-logo">
                <a href="login.html">
                <img src="{{asset('vendors/images/deskapp-logo.svg')}}" alt="" />
                </a>
            </div>
            <div class="login-menu">
                <ul>
                    <!-- <li><a href="java:void(0)" id="register">Regisdfster</a></li> -->
                </ul>
            </div>
            </div>
        </div>

            <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                        <h3 id="top-title">Login</h3>
                                </div>
                                <div class="card-body">
                                     @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <!-- Display error message -->
                                    @if(session('errors'))
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach(session('errors')->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{route('login')}}"> @csrf <div class="form-group row"> <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID</label> <div class="col-md-6">
                                        <input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="employee_id"> @error('employee_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row"> <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4"> <button type="submit" class="btn btn-primary"> Login </button> </div> </div> </form>
                                </div>
                            </div>
                        </div>
                </div>
                
            </div>

        <!-- welcome modal end -->
        <!-- js -->
        <script src="{{asset('vendors/scripts/core.js')}}"></script>
        <script src="{{asset('vendors/scripts/script.min.js')}}"></script>
        <script src="{{asset('vendors/scripts/process.js')}}"></script>
        <script src="{{asset('vendors/scripts/layout-settings.js')}}"></script>
        <script src="{{asset('src/plugins/jquery-steps/jquery.steps.js')}}"></script>
        <script src="{{asset('vendors/scripts/steps-setting.js')}}"></script>
        <!-- Google Tag Manager (noscript) -->
        <script type="text/javascript">
           $(function () {

//               let registerCol =   `<form method="POST" action="{{route('register')}}"> @csrf <div class="form-group row"> <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label> <div class="col-md-6">
// <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus> @error('name') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> 
//     <div class="form-group row"><label for="mobile_no" class="col-md-4 col-form-label text-md-right">Mobile number</label><div class="col-md-6"> <input id="mobile_no" type="text" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{ old('mobile_no') }}" required autocomplete="mobile_no" autofocus>@error('mobile_no') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror</div></div> 
// <div class="form-group row"> <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> <div class="col-md-6">
// <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"> @error('email') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row"> <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> <div class="col-md-6">
// <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row"> <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> <div class="col-md-6"> <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> </div> </div> 
// <div class="form-group row"><label for="name" class="col-md-4 col-form-label text-md-right">Sponsor ID</label><div class="col-md-6"><input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" placeholder="JIO101"> @error('employee_id')<span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div></div>
// <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4"> <button type="submit" class="btn btn-primary"> Register </button> </div> </div> </form>`;

let loginCol =   `<form method="POST" action="{{route('login')}}"> @csrf <div class="form-group row"> <label for="employee_id" class="col-md-4 col-form-label text-md-right">Employee ID</label> <div class="col-md-6">
<input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') }}" required autocomplete="employee_id"> @error('employee_id') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row"> <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> <div class="col-md-6">
<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password"> @error('password') <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span> @enderror </div> </div> <div class="form-group row mb-0"> <div class="col-md-6 offset-md-4"> <button type="submit" class="btn btn-primary"> Login </button> </div> </div> </form>`;

                var initialContent = $(".card-body").html();

                    $(document).on('click', '#auth-link', function () {
                        $(this).text('Register').attr('id', 'register');
                        $(".card-body").html(loginCol);
                        $("#top-title").text('Login');
                    });

                    $(document).on('click', '#register', function () {
                        $(this).text('Login').attr('id', 'auth-link');
                        $(".card-body").html(registerCol);
                        $("#top-title").text('Register');
                    });
            });
        </script>
    </body>
</html>
