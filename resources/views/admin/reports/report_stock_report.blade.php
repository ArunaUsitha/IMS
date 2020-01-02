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
                <h5>Full Stock Report</h5>
            </td>
            <td></td>
        </tr>

    </table>


    <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
        <tr>
            <th class="text-center">Product Code</th>
            <th class="text-center">Product Name</th>
            <th class="text-center">Stock</th>
            <th class="text-center">Status</th>
        </tr>
        @if(count($data['stock_info'])>0)
            @foreach($data['stock_info'] as $stock)
                <tr>
                    <td class="text-center">{{$stock->code}}</td>
                    <td class="text-center">{{$stock->name}}</td>
                    <td class="text-center">{{$stock->stock}}</td>
                    <td class="text-center">{!! ($stock->stock > $stock->reorder_point) ? '<label class="badge badge-success">Good</label>' : '<label class="badge badge-danger">low</label>' !!}</td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" class="text-center">No Data found</td>
            </tr>
        @endif
    </table>
@endsection
