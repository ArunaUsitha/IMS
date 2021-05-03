@extends('layouts.admin-master')

@section('title')
    Product History
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/product/product_overview.js')}}"></script>
@endsection

@section('css')
    {{--    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/user/user_index.css')}}">--}}
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Purchase Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Purchase</a></div>
                    <div class="breadcrumb-item"><a href="#">Advanced View</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Advanced view</h2>
                <p class="section-lead">
                    Deep down view of a selected puchase order.
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
                            <div class="col-md-3">
{{--                                <input type="text" id="dTableSearchBox" name="search" class="form-control"--}}
{{--                                       placeholder="Search">--}}
                            </div>
                            <div class="col-md" style="">

                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        {{--                        {{dd($product_info)}}--}}

                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h4>{{$order_and_supplier_info->order_code}}</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <ul>
                                            <li> <strong> Supplier Name : </strong> {{$order_and_supplier_info->name}}</li>
                                            <li> <strong> Company Name : </strong> {{$order_and_supplier_info->company_name}}</li>
                                            <li> <strong> Email : </strong> {{$order_and_supplier_info->email}}</li>
                                            <li> <strong> Category : </strong> {{$order_and_supplier_info->product_category_name}}</li>
                                        </ul>
                                    </div>   <div class="col-6">
                                        <ul>
                                            <li> <strong> Address :  </strong>{{$order_and_supplier_info->address}}</li>
                                            <li> <strong> Mobile :  </strong>{{$order_and_supplier_info->mobile}}</li>
                                            <li> <strong> Fixed :  </strong>{{$order_and_supplier_info->fixed}}</li>

                                        </ul>
                                    </div>
                                </div>




                                <div id="accordion">
                                    <div class="accordion">
                                        <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                            <h4>Product List </h4>
                                        </div>
                                        <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                                            <table class="table table-striped table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Product Code</th>
                                                    <th>Name</th>
                                                    <th>Model No</th>
                                                    <th>Quantity</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($purchase_order_products as $purchase)
                                                    {{--                                                        {{dd($purchase)}}--}}
                                                    <tr>
                                                        <td>{{$purchase->code}}</td>
                                                        <td>{{$purchase->name}}</td>
                                                        <td>{{$purchase->model_no}}</td>
                                                        <td>{{$purchase->quantity}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
