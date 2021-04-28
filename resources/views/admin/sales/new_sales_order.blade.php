@extends('layouts.admin-master')

@section('title')
  Create New Sales Order
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/sales/sale_order_create.js')}}"></script>
@endsection


@section('content')

    <input type="hidden" value="{{$sales_order_no}}" id="sales_order_no">
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Sales Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Sales</a></div>
                    <div class="breadcrumb-item"><a href="#">New Sales Order</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">New Sales Order</h2>
                <p class="section-lead">
                   A user can create a new sales order for inhouse customer. Also sales quotation can be generated.
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
                                <fieldset class="border p-3">
                                    <legend class="w-auto h4 p-2">Customer Info</legend>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{Route('sales.customerCreate')}}" target="_blank"
                                               class="btn btn-success btn-sm">Register New Customer</a>
                                            <hr>
                                        </div>

                                    </div>
                                    <div class="row" id="salesCustomer">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="customerSearch">Search Customer</label>
                                                <select class="customerSearch form-control form-control-sm"
                                                        id="customerSearch">

                                                </select>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="row">


                                        <div class="col-4">
                                            <hr>

                                            <p><strong>Customer Name :</strong> <span id="supCustomerName"></span></p>
                                            <p><strong>Mobile :</strong> <span id="supCustomerMobile"></span></p>

                                        </div>
                                        <div class="col-4">
                                            <hr>
                                            <p><strong>Address :</strong> <span id="supCustomerAddress"></span></p>
                                        </div>

                                    </div>
                                </fieldset>


                            </div>

                            <div class="col-10 offset-1">
                                <fieldset class="border p-3 mt-2">
                                    <legend class="w-auto h4 p-2">Products Info</legend>
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="btnAddProduct" class="btn btn-success btn-sm" disabled>Add
                                                Product
                                            </button>
                                        </div>

                                    </div>
                                    <div class="row">

                                        <div class="col-12">
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-slate table-sm">
                                                    <thead class="">
                                                    <tr>
                                                        <th>product Code</th>
                                                        <th>Product Name</th>
                                                        <th>Warranty Period</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="tbodyProducts">

                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3 offset-9">
                                            <div class="form-group row">
                                                <label for="fullTotal" class="col-sm-3 offset-1 col-form-label">Total
                                                    : </label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control form-control-sm"
                                                           id="fullTotal" value="0">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
{{--                                            <div class="form-group float-left">--}}
{{--                                                <button type="button" class="btn btn-primary" id="btPrintQuote" >--}}
{{--                                                    Print Quotation--}}
{{--                                                </button>--}}
{{--                                                <button type="button" class="btn btn-primary" id="btPrint" >--}}
{{--                                                    Print--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
                                            <div class="form-group float-right">

                                                <button type="button" class="btn btn-success" id="btCheckout" >
                                                    Checkout
                                                </button>
                                                <button type="button" class="btn btn-warning" id="btClear" >
                                                    Clear
                                                </button>
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

                            <input type="hidden" id="mdWarranty" name="mdWarranty">
                            <input type="hidden" id="mdTotal" name="mdTotal">
                            <input type="hidden" id="mdProductCode" name="mdProductCode">

                            <div class="form-group">
                                <label for="slctItems">Select Product</label>
                                <select class="slctItems form-control form-control-sm" id="slctItems"
                                        name="slctItems"></select>
                            </div>

                            <div class="form-group">
                                <label for="mdQuantity">Quantity</label>
                                <input type="number" value="0" class="form-control form-control-sm" id="mdQuantity"
                                       name="mdQuantity">
                                <span id="mdQuantitySpan" class="text-danger"></span>
                            </div>

                            <div class="form-group">
                                <label for="mdPrice">Price</label>
                                <input readonly type="number" value="0" class="form-control form-control-sm" id="mdPrice"
                                       name="mdPrice">
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






