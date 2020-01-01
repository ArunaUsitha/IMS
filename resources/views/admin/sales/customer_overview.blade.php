@extends('layouts.admin-master')

@section('title')
    Customer Overview
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/sales/customer_overview.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Sales Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Customer</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Customer Overview</h2>
                <p class="section-lead">
                    Full overview of all registered customers are shown here.
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
                                    @can('create',Auth::user())
                                        <a href="{{Route('sales.customerCreate')}}" class="btn btn-success float-right">Register
                                            New
                                            Customer</a>
                                    @endcan
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-sm" id="tblCustomerOverview">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>gender</th>
                                            <th>Mobile</th>
                                            <th>Address</th>
                                            <th>email</th>
                                            <th>Joined On</th>
                                            <th>Status</th>
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


@endsection
