@extends('layouts.report-layout')

@section('reportContent')
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
                    <h5>Supplier Report for &nbsp;&nbsp;&nbsp; supplier ID : {{$data['supplier_info']->id}} &nbsp;&nbsp; Name : {{$data['supplier_info']->name}} </h5>
                </td>
                <td></td>
            </tr>

        </table>
        <?php
        $oldInvoice = null

        ?>

        @if(count($data['supplier_data'])>0)
            @foreach($data['supplier_data'] as $key => $suppliers)
                <br>
                <h4>Invoice No : {{$key}}</h4>
                <br>

                <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
                    <tr>
                        <th class="text-center">Product Code</th>
                        <th class="text-center">Prodcut Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Buy Price</th>
                        <th class="text-center">Sell Price</th>
                        <th class="text-center">Warranty</th>
                        <th class="text-center">Total</th>
                    </tr>

                    @foreach($suppliers as $supplier)

                        <tr>
                            <td class="text-center">{{$supplier->code}}</td>
                            <td class="text-center">{{$supplier->name}}</td>
                            <td class="text-center">{{$supplier->quantity}}</td>
                            <td class="text-center">{{$supplier->buy_price}}</td>
                            <td class="text-center">{{$supplier->sell_price}}</td>
                            <td class="text-center">{{$supplier->warranty_period}}</td>
                            <td class="text-center">{{$supplier->total}}</td>

                        </tr>
                    @endforeach
                </table>
            @endforeach

        @else

            <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
                <tr>
                    <th class="text-center">Product Code</th>
                    <th class="text-center">Prodcut Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Buy Price</th>
                    <th class="text-center">Sell Price</th>
                    <th class="text-center">Warranty</th>
                    <th class="text-center">Total</th>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">No Data found</td>
                </tr>
            </table>
        @endif
@endsection
