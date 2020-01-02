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
                    <h5>Sales Report for Dates Between : {{$data['date_range']['fromDate']}} to {{$data['date_range']['toDate']}}</h5>
                </td>
                <td></td>
            </tr>

        </table>


        <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
            <tr>
                <th class="text-center">Product Code</th>
                <th class="text-center">Prodcut Name</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Sold Date</th>
            </tr>
            @if(count($data['sales_data'])>0)
                @foreach($data['sales_data'] as $log)
                    <tr>
                        <td class="text-center">{{$log->code}}</td>
                        <td class="text-center">{{$log->name}}</td>
                        <td class="text-center">{{$log->quantity}}</td>
                        <td class="text-center">{{$log->sold_date}}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">No Data found</td>
                </tr>
            @endif
        </table>

@endsection
