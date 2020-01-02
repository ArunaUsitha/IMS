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
                    <h4>##Sales Quotation</h4>
                </td>
                <td></td>
            </tr>

        </table>



        <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
            <tr>
                <th class="text-center">Product Code</th>
                <th class="text-center">Product Name</th>
                <th class="text-center">Warranty</th>
                <th class="text-center">Price</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Total</th>
            </tr>
            @foreach($data['sales_details'] as $sale)
                <tr>
                    <td class="text-center">{{$sale['productCode']}}</td>
                    <td class="text-left">{{$sale['productName']}}</td>
                    <td class="text-center">{{$sale['warranty']}}</td>
                    <td>{{$sale['price']}}</td>
                    <td class="text-center">{{$sale['quantity']}}</td>
                    <td  class="text-center">{{$sale['total']}}</td>

                </tr>
            @endforeach
        </table>

        <table style="width: 100%">
            <tr>
                <td align="right">
                    <hr class="mt-2 mb-2">
                    <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Total</div>
                        <div class="invoice-detail-value">{{$data['header_details']['total']}}</div>
                    </div>
                </td>
            </tr>
        </table>



    </div>

</div>
</body>
</html>
