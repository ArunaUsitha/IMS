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
                    <h5>Customer Report for customer ID : {{$data['customer_info']->id}}</h5>
                </td>
            </tr>
            <tr>
                <td>Customer Name : {{$data['customer_info']->name}}</td>
                <td>Customer Mobile : {{$data['customer_info']->mobile}}</td>
            </tr>
            <tr>
                <td>Customer Address : {{$data['customer_info']->address}}</td>
            </tr>

        </table>


        @if(count($data['customer_data'])>0)
            @foreach($data['customer_data'] as $key => $customers)
                <br>
                <h4>Invoice No : {{$key}}</h4>
                <br>

                <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
                    <tr>
                        <th class="text-center">Product Code</th>
                        <th class="text-center">Prodcut Name</th>
                        <th class="text-left">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-left">Total</th>
                    </tr>

                    @foreach($customers['customer_sales_data'] as $customer)

                        <tr>
                            <td class="text-center">{{$customer->code}}</td>
                            <td class="text-center">{{$customer->name}}</td>
                            <td class="text-center">{{$customer->price}}</td>
                            <td class="text-center">{{$customer->quantity}}</td>
                            <td class="text-center">{{$customer->total}}</td>

                        </tr>
                    @endforeach
                </table>
            @endforeach

        @else

            <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
                <tr>
                    <th class="text-center">Product Code</th>
                    <th class="text-center">Prodcut Name</th>
                    <th class="text-left">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-left">Total</th>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">No Data found</td>
                </tr>
            </table>
        @endif

@endsection
