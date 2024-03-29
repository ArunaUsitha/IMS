@extends('layouts.admin-master')

@section('title')
    Product Overview
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
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Product Overview</h2>
                <p class="section-lead">
                    A List of all available items can be seen here.
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
                            <div class="col-md-3">
                                <input type="text" id="dTableSearchBox" name="search" class="form-control"
                                       placeholder="Search">
                            </div>
                            <div class="col-md" style="">
                                <div class="card-header-action">
{{--                                    @can('create',Auth::user())--}}
                                        <a href="{{Route('product.create')}}" class="btn btn-success float-right">Add New
                                            Product</a>
{{--                                    @endcan--}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">


                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblProdcutOverview">
                                        <thead>
                                        <tr>
                                            <th>Prodcuct code</th>
                                            <th>Custom code</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Model</th>
                                            <th>Status</th>
                                            <th>Added on</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>


    {{--    modals--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="mdSetPricing" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Set Product Price <strong class="text-warning"><span id="mdUsername"></span> </strong></h4>
                    </div>
                    <form id="mdUpdateDefaultPrice">
                        <div class="card-body">
                            <input type="hidden" name="product_id" id="mdProdcutId">


                            <p>Sell Prices List of last puchased orders</p>
                            <div id="purchased_product_sell_prices">

                            </div>


                            <div class="form-group">
                                <label>Default Sell Price</label>
                                <input type="text" name="default_sell_price" id="default_sell_price" class="form-control form-control-sm">
                            </div>

                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtUpdateDefaultPrice">Set/Update</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    @endsection
