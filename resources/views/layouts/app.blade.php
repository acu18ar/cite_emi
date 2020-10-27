<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{!! csrf_token() !!}">
        <meta name="_token" content="{!! csrf_token() !!}">
        {{ Html::favicon(url('/') . '/ICON.png' ) }}
        <title>{{ config('app.name') }}</title>
        @include('partials.css')
        @include('partials.scriptsDataTable')

    </head>
    <body class="fixed-left widescreen">
        <!-- Begin page -->
        <div id="wrapper">
            <!-- Top Bar Start -->
        @include('partials.topbar')
            <!-- Top Bar End -->
            <!-- ========== Left Sidebar start ========== -->
            <div class="left side-menu">
                @include('partials.sidebar')
            </div>
            <!-- ========== Left Sidebar end ========== -->

            <!-- ========== main content start ========== -->
            <div class="content-page">
                <!-- content -->
                <div class="content">
                    @yield('content')
                </div>
                <!-- content -->
                <!-- footer -->
                @include('partials.footer')
            </div>
            <!-- ====== main content end ========== -->
        </div>
    <!-- scripts -->
        @include('partials.scripts')
    </body>
</html>
