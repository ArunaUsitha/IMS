<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title', 'Dashboard') &mdash; {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script type="text/javascript">
        window.base_url = '{!! (url('/')); !!}';
    </script>
    <!-- General CSS Files -->
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"--}}
{{--          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"--}}
{{--          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">--}}

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('assets/vendors/izitoast/dist/css/iziToast.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('assets/vendors/sweetalert2/dist/sweetalert2.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('assets/vendors/sweetalert2-themes/dark/dark.scss')}}">--}}
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/DataTables-1.10.20/datatables.min.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/DataTables-1.10.20/Buttons-1.6.1/css/buttons.bootstrap4.css')}}">--}}
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/Responsive-2.2.3/css/responsive.bootstrap4.min.css')}}">--}}

    <!--Dynamic css inject-->
    @yield('css_vendors')

    <!--End Dynamic css inject-->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">

    @yield('css')

</head>

<body class="sidebar-mini">

<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('admin.partials.topnav')
        </nav>
        <div class="main-sidebar">
            @include('admin.partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">

                @yield('content')


        </div>
        {{--        <footer class="main-footer">--}}
        {{--            @include('admin.partials.footer')--}}
        {{--        </footer>--}}
    </div>
</div>

{{--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0QL-AIzaSyBgZIybmBwjQHu_NxL5Xe7okBONiGCUt80&callback=initMap"--}}
{{--        type="text/javascript"></script>--}}




{{--  <script src="{{ route('js.dynamic') }}"></script>--}}
<script src="{{ asset('js/app.js') }}?{{ uniqid() }}"></script>
<script src="{{ asset('assets/js/global_var.js') }}"></script>
<script src="{{ asset('assets/js/auth.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>--}}

<script src="{{asset('assets/vendors/izitoast/dist/js/iziToast.min.js')}}"></script>

{{--<script src="{{asset('assets/vendors/DataTables-1.10.20/js/jquery.dataTables.min.js')}}"></script>--}}
<script src="{{asset('assets/vendors/DataTables/datatables.min.js')}}"></script>
{{--<script src="{{asset('assets/vendors/DataTables-1.10.20/Buttons-1.6.1/js/buttons.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/vendors/DataTables-1.10.20/js/dataTables.bootstrap4.min.js')}}"></script>--}}

{{-- Form validator--}}
<script src="{{asset('assets/vendors/validator/js/validator.js')}}"></script>

{{--End Form validator--}}
@yield('js_vendors')



<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/stisla_.js') }}"></script>
{{--<script src="{{ asset('assets/js/custom.js') }}"></script>--}}

@yield('js')


</body>
</html>
