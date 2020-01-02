<html>
<body style="background-color: white">

<link rel="stylesheet" href="{{asset('css/app.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">

<div class="invoice">
    <div class="invoice-print">

        @yield('reportContent')

    </div>

</div>
</body>
</html>
