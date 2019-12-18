@extends('layouts.admin-master')

@section('title')
    Update Supplier
@endsection

{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/supplier/supplier_edit.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Supplier Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Supplier</a></div>
                <div class="breadcrumb-item"><a href="#">Update Supplier</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Update Supplier</h2>
            <p class="section-lead">
             Supplier details can be updated here.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{Route('supplier.create')}}" class="btn btn-primary">Add New Supplier</a>
                        <a href="{{Route('supplier.overview')}}" class="btn btn-primary">View All Suppliers</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmSupplierUpdate" method="post">
                        <input type="hidden" value="{{$supplier->id}}" name="supplier_id">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">

                                    <div class="col-6">


                                        <div class="form-group">
                                            <label for="supplier_name">Supplier Name</label>
                                            <input type="text" class="form-control form-control-sm" id="supplier_name" value="{{$supplier->name}}"
                                                   name="supplier_name"
                                                   placeholder="Name of the Supplier ">
                                        </div>

                                        <div class="form-group">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control form-control-sm" id="company_name" value="{{$supplier->company_name}}"
                                                   name="company_name"
                                                   placeholder="Name of the Company ">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="text" class="form-control form-control-sm" id="email" value="{{$supplier->email}}"
                                                   name="email"
                                                   placeholder="Email Address">
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="Address">Supplier Address</label>
                                            <textarea class="form-control form-control-sm" id="Address"
                                                      name="Address"
                                                      placeholder="Supplier Address">{{$supplier->address}}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Mobile No</label>
                                            <input type="text" class="form-control form-control-sm" id="mobile" value="{{$supplier->mobile}}"
                                                   name="mobile"
                                                   placeholder="Mobile No">
                                        </div>

                                        <div class="form-group">
                                            <label for="fixed_line">Fixed line No</label>
                                            <input type="text" class="form-control form-control-sm" id="fixed_line" value="{{$supplier->fixed}}"
                                                   name="fixed_line"
                                                   placeholder="Fixed line No">
                                        </div>


                                        <span class="float-right">
                            <button type="submit" class="btn btn-success" id="bt_submit">Update Supplier</button>

                                </span>

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
