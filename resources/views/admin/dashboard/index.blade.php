@extends('layouts.admin-master')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="row">

                <div class="col-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Orders</h4>
                            </div>
                            <div class="card-body">
                                {{$data['total_orders']}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Customers Registered</h4>
                            </div>
                            <div class="card-body">
                                {{$data['total_customers']}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Orders Today</h4>
                            </div>
                            <div class="card-body">
                               {{$data['orders_today']->count}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card gradient-bottom">
                        <div class="card-header ">
                            <h4 class="text-success">Top 5 Best Selling Products</h4>

                        </div>
                        <div class="card-body" id="top-5-scroll" tabindex="2"
                             style="height: 315px; overflow: hidden; outline: none;">
                            <ul class="list-unstyled list-unstyled-border">

                                                                @foreach($data['top_products'] as $product)
                                                                    <li class="media">
{{--                                                                                                      <img class="mr-3 rounded" width="55" src="../assets/img/products/product-1-50.png" alt="product">--}}
                                                                        <div class="media-body">
                                                                            <div class="float-right">
                                                                                <div
                                                                                    class="font-weight-600 badge badge-success">{{$product->sales}}</div>
                                                                            </div>
                                                                            <div class="media-title text-primary">{{$product->name}}</div>

                                                                        </div>
                                                                    </li>
                                                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer pt-3 d-flex justify-content-center">

                        </div>
                    </div>
                </div>

                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-danger">Latest Added Products</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Product Code</th>
                                        <th>Product Name</th>
                                        <th>Brand name</th>
                                        <th>Model No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                                                        @foreach($data['latest_added_products'] as $product)
                                                                            <tr>
                                                                                <td>{{$product->code}}</td>
                                                                                <td>{{$product->name}}</td>
                                                                                <td>{{$product->brand_name}}</td>
                                                                                <td>{{$product->model_no}}</td>
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
    </section>
@endsection
