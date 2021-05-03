@extends('layouts.admin-master')

@section('title')
    Purchase Orders Overview
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/purchase/overview.js')}}"></script>
@endsection

@section('css')
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Purchase Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Purchase</a></div>
                    <div class="breadcrumb-item"><a href="#">overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Purchase Overiew</h2>
                <p class="section-lead">
                  Overview of  all the purchase orders that are created.
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


                                    <table class="table table-striped table-hover table-sm" id="tblPurchaseOrdersOverview">
                                        <thead>
                                        <tr>
                                            <th>purchase Order Code</th>
                                            <th>Supplier Name</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Fixed</th>
                                            <th>Emailed on</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody id="tbodyPurchaseOrdersOverview">

                                        </tbody>

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
