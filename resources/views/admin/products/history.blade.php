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
                <h1>Product Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Product</a></div>
                    <div class="breadcrumb-item"><a href="#">History</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Product History</h2>
                <p class="section-lead">
                   Product info and more info can be seen here
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
{{--                            <div class="col-md-3">--}}
{{--                                <input type="text" id="dTableSearchBox" name="search" class="form-control"--}}
{{--                                       placeholder="Search">--}}
{{--                            </div>--}}
                            <div class="col-md" style="">
                                <div class="card-header-action">
                                    {{--                                    @can('create',Auth::user())--}}
{{--                                    <a href="{{Route('product.create')}}" class="btn btn-success float-right">Add New--}}
{{--                                        Product</a>--}}
                                    {{--                                    @endcan--}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

{{--                        {{dd($product_info)}}--}}

                        <div class="row">
                            <div class="col-md-8 offset-2">
                                <h4>{{$product_info->name}}</h4>
                                <div class="row">
                                    <div class="col-6">
                                        <ul>
                                            <li> <strong> Product code : </strong> {{$product_info->code}}</li>
                                            <li> <strong> Brand name : </strong> {{$product_info->brand_name}}</li>
                                            <li> <strong> Category : </strong> {{$product_info->product_category_name}}</li>
                                            <li> <strong> Category : </strong> {{$product_info->product_category_name}}</li>
                                        </ul>
                                    </div>   <div class="col-6">
                                        <ul>
                                            <li> <strong> Custom code :  </strong>{{$product_info->custom_code}}</li>
                                            <li> <strong> Model No :  </strong>{{$product_info->model_no}}</li>
                                            <li> <strong> Status :  </strong> <span class="badge {{($product_info->status == 1 ? 'badge-success' : 'badge-danger')}}">{{($product_info->status == 1 ? 'Active' : 'Deactive')}}</span>  </li>
                                            <li> <strong> Stock :  </strong> <span class="badge badge-info">{{$product_info->stock}}</span>  </li>
                                        </ul>
                                    </div>
                                </div>




                                <div id="accordion">
                                    <div class="accordion">
                                        <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                            <h4>Prodcut Purchase History </h4>
                                        </div>
                                        <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                                            <table class="table table-striped table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Invoice No</th>
                                                        <th>Supplier</th>
                                                        <th>Rep Name</th>
                                                        <th>Stocked On</th>
                                                        <th>Quantity Purchased</th>
                                                        <th>Buy Price</th>
                                                        <th>Sell Price</th>
                                                        <th>Warranty Period</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
{{--                                                @isset($product_purchase_history)--}}
                                                    @foreach($product_purchase_history as $purchase)
{{--                                                        {{dd($purchase)}}--}}
                                                    <tr>
                                                        <td>{{$purchase->invoice_no}}</td>
                                                        <td>{{$purchase->name}}</td>
                                                        <td>{{$purchase->sales_rep_name}}</td>
                                                        <td>{{$purchase->stocked_on}}</td>
                                                        <td>{{$purchase->quantity}}</td>
                                                        <td>{{$purchase->buy_price}}</td>
                                                        <td>{{$purchase->sell_price}}</td>
                                                        <td>{{$purchase->warranty_period}}</td>
                                                    </tr>
                                                    @endforeach
{{--                                                @endisset--}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="accordion">
                                        <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-2" aria-expanded="true">
                                            <h4>Product Sales history</h4>
                                        </div>
                                        <div class="accordion-body collapse show" id="panel-body-2" data-parent="#accordion">
                                            <table class="table table-striped table-hover table-sm">
                                                <thead>
                                                <tr>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Sold On</th>
                                                    <th>Quantity Sold</th>
                                                    <th>Sold Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
{{--                                                @foreach($product_sales_history as $purchase)--}}
{{--                                                    --}}{{--                                                        {{dd($purchase)}}--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{{$purchase->invoice_no}}</td>--}}
{{--                                                        <td>{{$purchase->initials .' '. $purchase->first_name .' ' . $purchase->last_name}}</td>--}}
{{--                                                        <td>{{$purchase->amount}}</td>--}}
{{--                                                        <td>{{$purchase->sold_on}}</td>--}}
{{--                                                        <td>{{$purchase->quantity}}</td>--}}
{{--                                                        <td>{{$purchase->price}}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endforeach--}}
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
