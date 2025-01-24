<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="https://cdhrms.com/static/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>

    Collegedunia - HRIS

    </title>

    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' />
    <!--     Fonts and icons     -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" type="text/css" href="https://cdhrms.com/static/css/bootstrap.min.css">

    
    <!--  Material Dashboard CSS    -->
    <link rel="stylesheet" type="text/css" href="https://cdhrms.com/static/css/material-dashboard.css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <style>
        p.title {
            font-size: 18px;
            margin: 20px 0px 20px 0;
        }
    </style>
</head>

<body>
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
        <br>

            @if($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif

        <br>

        
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <p class="title text-center">ATS | Login</p>
            </div>
            <div class="card-content text-center">
            
                <div class="row">
                    <img alt="Google sign-in" src="{{asset('images/login-page-img.png')}}" style="border:1px solid gray; border-radius: 1vmin;" />

                    <div class="col m6 offset-m3 center-align">
                        <form method="get" action="{{route('google.login')}}">
                        <!-- <form method="get" action="{{route('google.login')}}"> -->
                            <input type="hidden" name="_token" value="BIAod5l9X22fZQjPBGGrJaNM2jfAF3hj1QfDyIpb">
                            <button type="submit" class="oauth-container btn darken-4 white black-text" href="https://cdhrms.com/google-login" style="text-transform:none;">
                                <div class="left">
                                    <img style="width:18px; margin-right:8px" alt="Google sign-in" 
                                    src="{{asset('images/google_logo.png')}}"/>
                                </div>
                                Login with Google
                            </button>
                        </form>
                    </div>
                </div>
                <small><p class="text-danger" style="font-size:13px;">Use Email Address registered with CDHRMS Portal</p></small>
            </div>
            <br>

        </div>
    </div>

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

    <script src="https://cdhrms.com/static/js/jquery-3.1.0.min.js"></script>
    <script src="https://cdhrms.com/static/js/bootstrap.min.js"></script>
    <script src="https://cdhrms.com/static/js/material.min.js"></script>
    <script src="https://cdhrms.com/static/js/jquery.validate.min.js"></script>
</body>

</html>
