<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{ Html::favicon( url('/') . '/ICON.png' ) }}
        <title>{{ config('app.name') }}</title>
        <!-- Fonts -->
        @include('partials.css')
        @include('partials.scriptsDataTable')
        @include('partials.scripts')
    </head>
    <body class="accountbg">
        <!-- Begin page -->
        <div id="">
            <div class="">
                <!-- content -->
                <div class="content">
                    @yield('content')
                </div>
            </div>
            {{-- @include('partials.footer') --}}
        </div>
        
    </body>
</html>
