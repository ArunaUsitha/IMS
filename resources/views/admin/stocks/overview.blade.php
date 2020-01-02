@extends('layouts.admin-master')

@section('title')
    Stocks Overview
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/stock/overview.js')}}"></script>
@endsection



@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Stock Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Stocks</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Stocks Overview</h2>
                <p class="section-lead">
                    Full system stocks overview available here.
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

                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">


                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblStocksOverview">
                                        <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Product Code</th>
                                            <th>Custom Product Code</th>
                                            <th>Product Category</th>
                                            <th>Product Model</th>
                                            <th>Product Name</th>
                                            <th>Quantity Available</th>
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
    @endsection('content')
