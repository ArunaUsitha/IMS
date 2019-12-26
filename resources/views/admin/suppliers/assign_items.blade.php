@extends('layouts.admin-master')

@section('title')
    Assign Items
@endsection

{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/supplier/assign_items.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Supplier Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Supplier</a></div>
                <div class="breadcrumb-item"><a href="#">Assign Items</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Assign Items for Supplier</h2>
            <p class="section-lead">
                Items that are added to the system can be assigned to the supplier. These assigned items will be used in
                the GRN and Purchase orders.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{Route('supplier.overview')}}" class="btn btn-primary">View All Suppliers</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmSupplierAssignItems" method="post">
{{--                        <div class="row justify-content-center">--}}
                        <div class="row">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                                                                    <label for="itemSearch">Seach and add items</label>
                                            <select class="itemSearch" id="itemSearch" name="items[]" multiple="multiple">

                                            </select>
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
