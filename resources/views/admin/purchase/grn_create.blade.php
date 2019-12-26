@extends('layouts.admin-master')

@section('title')
    Insert GRN
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/purchase/grn_create.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/purchase/grn_create.css')}}">
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Purchase Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Purchase</a></div>
                    <div class="breadcrumb-item"><a href="#">Insert GRN</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Insert GRN</h2>
                <p class="section-lead">
                    Here a user can insert items when items were received using GRN
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md" style="">
                                <div class="card-header-action">

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row mx-auto">
                            <div class="col-10 offset-1">
{{--                                <h4>Supplier Info</h4>--}}
{{--                                <hr>--}}
                                <fieldset class="border p-3">
                                    <legend  class="w-auto h4 p-2">Supplier Info</legend>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{Route('supplier.create')}}" target="_blank" class="btn btn-success btn-sm">Register New Supplier</a>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="supplierSearch">Search Supplier</label>
                                                <select class="supplierSearch" id="supplierSearch">

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4 offset-1">

                                            <p><strong>Company Name :</strong> <span id="companyName"></span></p>
                                            <p><strong>Email :</strong> <span id="email"></span></p>

                                        </div>
                                        <div class="col-4">
                                            <p><strong>Address :</strong> <span id="address"></span></p>
                                        </div>

                                    </div>
                                </fieldset>


                            </div>

                            <div class="col-10 offset-1">
{{--                                <h4>Products Info</h4>--}}
{{--                                <hr>--}}
                                <fieldset class="border p-3 mt-2">
                                    <legend  class="w-auto h4 p-2">Products Info</legend>
                                <div class="row">
                                    <div class="col-12">
                                        <button id="btnAddProduct" class="btn btn-success btn-sm" disabled>Add Product</button>
                                        <a href="{{Route('product.create')}}" target="_blank" class="btn btn-primary btn-sm">Register New Product</a>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-12">
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-slate table-sm">
                                                <thead class="">
                                                <tr>
                                                    <th>product ID</th>
                                                    <th>Product Name</th>
                                                    <th>Unit Price</th>
                                                    <th>Units</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody id="tblProducts">

                                                </tbody>
                                            </table>
                                        </div>





                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-3 offset-9">
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 offset-1 col-form-label">Total : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control form-control-sm" id="fullTotal" value="0">
                                                </div>
                                            </div>
                                            <div class="form-group float-right">
                                                <button type="submit" class="btn btn-success" id="mdBtUpdateUser" disabled>Save GRN</button>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>


    <div class="modal fade" tabindex="-1" role="dialog" id="mdAddProduct" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Add Products</h4>
                    </div>

                    <div class="card-body">
                        <form id="FrmMdAddProduct">
                            <div class="form-group">
                                <label for="slctItems">Select Product</label>
                                <select class="slctItems form-control form-control-sm" id="slctItems" name="slctItems"></select>
                            </div>

                            <div class="form-group">
                                <label for="mdQuantity">Quantity</label>
                                <input type="number" class="form-control form-control-sm" id="mdQuantity"
                                       name="mdQuantity">
                            </div>

                            <div class="form-group">
                                <label for="mdUnitPrice">Unit Price</label>
                                <input type="text" class="form-control form-control-sm" id="mdUnitPrice"
                                       name="mdUnitPrice">
                            </div>

                            <div class="form-group">
                                <label for="mdTotal">Total</label>
                                <input type="number" readonly value="0" class="form-control form-control-sm"
                                       id="mdTotal" name="mdTotal">
                            </div>



                        <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtAddProducts" value="add">Add</button>

                                </span>
                        </form>
                    </div>

                </div>
            </div>


        </div>
    </div>


@endsection






