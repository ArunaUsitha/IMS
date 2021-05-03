<html>
<body style="background-color: white">

{{--{{dd($data)}}--}}

<link rel="stylesheet" href="{{asset('css/app.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">

<div class="invoice">
    <div class="invoice-print">
        {{--        invoice header--}}
        <table style="width: 100%">
            <tr>
                <td class=" text-center"><h2>{{$data['header_details']['company_name']}}</h2></td>
            </tr>
            <tr class="border-bottom">
                <td class="text-center"><h6>{{$data['header_details']['company_address']}} </h6>
                    <h6>Tel : {{$data['header_details']['company_phone']}}</h6></td>
            </tr>
        </table>

        <table style="margin-top: 10px">
            <tr>
                <td>
{{--                    <h5>invoice No : #{{$data['customer_details']->invoice_no}}</h5>--}}
                </td>
                <td></td>
            </tr>

        </table>

        <table style="width: 100%; margin-top: 20px">
            <tr>
                <td>
                    <address>
                        <strong>Billed To:</strong><br>
                        {{$data['details']['supplier_details']->name}}&nbsp;
{{--                        &nbsp;{{($data['customer_details']->last_name) !== null ? $data['customer_details']->last_name : ''}}--}}
                        <br>
{{--                        {{$data['customer_details']->address_no}}<br>--}}
{{--                        {{$data['customer_details']->address_street}}<br>--}}
{{--                        {{$data['customer_details']->address_city}}--}}
                    </address>
                </td>
            </tr>
        </table>

        <table class="table table-striped table-hover table-sm">
            <tr>
{{--                <th class="text-center">Product Code</th>--}}
                <th class="text-center">Product Name</th>
                <th class="text-center">Quantity</th>
            </tr>
            @foreach($data['details']['product_details'] as $product)
                <tr>
                    <td class="text-center">{{$product->name}}</td>
                    <td class="text-left">{{$product->quantity}}</td>

                </tr>
            @endforeach
        </table>

        <table style="width: 100%">
            <tr>
                <td align="right">
                    <hr class="mt-2 mb-2">
                    <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Total</div>
{{--                        <div class="invoice-detail-value">{{$data['customer_details']->amount}}</div>--}}
                    </div>
                </td>
            </tr>
        </table>



    </div>

</div>
</body>
</html>
