<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <title>{{ config('app.name') }}</title> --}}
        {{-- {{ Html::favicon( '/ICON.png' ) }} --}}
        <title> C.I.T.E.</title>

        <script src="assets3/js/jquery-1.11.3.min.js"></script>

        <link rel="icon"  type="image/png" href="/assets3/images/logocite.png">

        <!-- Styles -->
        @include('partials.css')
    </head>
<body class="widescreen accountbg">
        <!-- Begin page -->
        <div class="wrapper-page">
            <div class="card card-pages">
                <div class="card-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        {{-- <a href="#" class="logo logo-admin"><img src="{{ url('/') }}/images/emi_logo.png" alt="" style="width:250px;"></a> --}}
                        <a href="#" class="logo logo-admin"><img src="/assets3/images/logocite.png" alt="" style="width:250px;"></a>
                    </h3>
                    {{-- <h4 class="text-center m-t-0 app-name"><b>{{ config('app.name') }}</b></h4> --}}
                    <h4 class="text-center m-t-0 app-name"><b>CITE</b></h4>

                    <form class="form-horizontal m-t-20" method="post" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control {{ $errors->first('email', 'parsley-error') }}" type="text" required="" name="email" placeholder="Correo Electrónico">
                                @if ($errors->has('email'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-9">
                                        <li class="parsley-required">{{ $errors->first('email') }}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <input class="form-control" type="password" required="" name="password" placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-9">
                                        <li class="parsley-required">{{ $errors->first('password') }}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <div class="col-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup">
                                        Recuérdame
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        @if(session()->has('warning'))
                            <div class="container">
                                <div class="alert alert-warning">{{ session('warning') }}</div>
                            </div>
                        @endif
                        @if(config('parameters.auth_google_recaptcha'))
                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                {!! Recaptcha::render() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <ul class="parsley-errors-list filled" id="parsley-id-9">
                                        <li class="parsley-required">{{ $errors->first('g-recaptcha-response') }}</li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Iniciar Sesión</button>
                            </div>
                       {{--<div class="col-12">
                           <button class="btn btn-primary btn-block btn-lg waves-effect waves-light" type="submit">Olvido su Contraseña</button>
                           </div>  --}}
                        </div>
                        @if(config('parameters.auth_office365'))
                        <div class="form-group text-center m-t-40">
                            <div class="col-12">
                                <a href="{{ route('login.microsoft') }}" class="btn btn-microsoft btn-block">Iniciar sesión con Office 365 <i class="fab fa-windows"></i></a>
                            </div>
                        </div>
                        @endif
                    </form>
                
                </div>
                
                </div>

            </div>
        </div>
        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
</body>
</html>
