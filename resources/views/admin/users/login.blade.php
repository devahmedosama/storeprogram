<!DOCTYPE html>
<?php 
        $lang =  App::getLocale();
        $setting  =  App\Models\Setting::first();
?>
<html lang="{{ $lang }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $setting->name }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::to('assets/admin') }}/images/logo/favicon.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="{{ URL::to('assets/admin') }}/css/app.min.css" rel="stylesheet">

</head>

<body>
    <div class="app">
        <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('{{ URL::to('assets/admin') }}/images/others/login-3.png')">
            <div class="d-flex flex-column justify-content-between w-100">
                <div class="container d-flex h-100">
                    <div class="row align-items-center w-100">
                        <div class="col-md-7 col-lg-5 m-h-auto">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between m-b-30">
                                        <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                                        <h2 class="m-b-0">Login </h2>
                                    </div>
                                    @if (session('yes'))
                                    <div class="alert alert-success">
                                        {{ session('yes') }}
                                    </div>
                                    @endif
                                    @if (session('no'))
                                    <div class="alert alert-danger">
                                        {{ session('no') }}
                                    </div>
                                    @endif
                                    {{ Form::open(['url'=>'login']) }}
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="userName">Username :</label>
                                            <div class="input-affix">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                {{ Form::text('username',null,['class'=>'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Password :</label>
                                            <div class="input-affix m-b-10">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                               {{ Form::password('password',['class'=>'form-control','required']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                
                                                <button type="submit" class="btn btn-primary pull-right"> Login  </button>
                                            </div>
                                        </div>
                                    {{ Form::token() }}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    
    <!-- Core Vendors JS -->
    <script src="{{ URL::to('assets/admin') }}/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="{{ URL::to('assets/admin') }}/js/app.min.js"></script>

</body>

</html>