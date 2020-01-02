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
                    <h5>User Activity Report for User : {{$data['user_data']->id}}</h5>
                </td>
                <td></td>
            </tr>

        </table>


        <table class="table table-striped table-hover table-sm" style="margin-top: 30px">
            <tr>
                <th class="text-center">log ID</th>
                <th class="text-center">Description</th>
                <th class="text-center">Date</th>
            </tr>
            @if(count($data['activity_log'])>0)
                @foreach($data['activity_log'] as $log)
                    <tr>
                        <td class="text-center">{{$log->id}}</td>
                        <td class="text-center">{{$log->description}}</td>
                        <td class="text-center">{{$log->date}}</td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center">No Data found</td>
                </tr>
            @endif
        </table>
@endsection
