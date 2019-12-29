@extends('layouts.admin-master')

@section('title')
    New Purchase Order
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/purchase/purchase_create.js')}}"></script>
@endsection

@section('css')
    {{--    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/user/user_index.css')}}">--}}
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Purchase Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Purchase</a></div>
                    <div class="breadcrumb-item"><a href="#">Create</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Purchase Create</h2>
                <p class="section-lead">
                    Here the user can create a purchase order.
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md" style="">
                                <div class="card-header-action">
                                    @can('read',Auth::user())
                                        <a href="{{Route('purchase.overview')}}" class="btn btn-success float-right">View
                                            All purchase orders</a>
                                    @endcan
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-10  mx-auto">
                                <div id="smartwizard">
                                    <ul>
                                        <li><a href="#step-1">Select Supplier<br/><small>Select the desired supplier who
                                                    you wish to make the purchase order</small></a></li>
                                        <li><a href="#step-2">Select Items<br/><small>Select Items that want to add to
                                                    the purchase order</small></a></li>
                                        <li><a href="#step-3">Email, Save or Print<br/><small>Email, Print or save
                                                    pruchase order</small></a></li>
                                    </ul>

                                    <div class="wizard-content">
                                        <div id="step-1" class="">
                                            {{--step1--}}
                                            <div class="row">
                                                <div class="col-4" id="selectDiv">
                                                    <div class="form-group">
                                                        <label for="supplier">Select Suppliers</label>
                                                        <select type="text" class="form-control form-control-sm"
                                                                id="supplier" name="supplier">
                                                            <option value="-1">Select title</option>
                                                            @foreach($suppliers as $supplier)
                                                                <option
                                                                    value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-6 offset-1">
                                                    <div class="card border">
                                                        <div class="card-body">
                                                            <p><strong>Company Name :</strong> <span
                                                                    id="companyName"></span></p>
                                                            <p><strong>Email :</strong> <span id="email"></span></p>
                                                            <p><strong>Address :</strong> <span id="address"></span></p>
                                                            <p><strong>Fixed line :</strong> <span id="fixed"></span>
                                                            </p>
                                                            <p><strong>Mobile :</strong> <span id="mobile"></span></p>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>


                                        </div>
                                        <div id="step-2" class="">

                                            <div class="row">
                                                <div class="col-12">
                                                    <button class="btn btn-success" id="btnAddProduct">Add Product
                                                    </button>
                                                    <hr>
                                                    <table class="table table-striped table-slate table-sm">
                                                        <thead>
                                                        <tr>
                                                            <th>item ID</th>
                                                            <th>item Name</th>
                                                            <th>Quantity</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbodyPurchaseOrder">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                        <div id="step-3" class="">
                                            <div class="row justify-content-center" id="toPrint">
                                                <div class="col-10 ">

                                                    <div class="text-center"><h3>Purchase Order</h3></div>
                                                    <hr>
                                                    <div class="float-left">
                                                        <h5>Supplier: <span id="supplierNamePO"></span></h5>
                                                        <p id="addressPO"></p>
                                                    </div>

                                                    <div class="float-right">
                                                        <h5>Purchase Order No:</h5>
                                                        <p id="PONo"></p>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <hr>


                                                    <table class="table table-sm table-striped ">
                                                        <thead>
                                                        <tr>
                                                            <th>Item ID</th>
                                                            <th>Item Name</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbodyPO">

                                                        </tbody>
                                                    </table>


                                                    <div class="clearfix"></div>
                                                    <hr>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <div class="col-2 offset-9">
                                                    <div class="float-right">
                                                        <button class="btn btn-warning" id="btnPrint">Print</button>
                                                        <button class="btn btn-success" id="btSavePurchaseOrder">Save</button>
                                                    </div>
                                                </div>
                                            </div>
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


    <div class="modal fade" tabindex="-1" role="dialog" id="mdAddPurchaseItem" style="display: none;"
         aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">

                    <div class="card-header">
                        <h4>Add Product</h4>
                    </div>

                    <form id="mdFrmAddProduct">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="mdSlctItems">Select Product</label>
                                <select class="slctItems form-control form-control-sm" id="mdSlctItems"
                                        name="mdSlctItems"></select>
                            </div>

                            <div class="form-group">
                                <label for="mdQuantity">Quantity</label>
                                <input class="form-control form-control-sm" id="mdQuantity" name="mdQuantity">
                            </div>

                            <span class="float-right">
                                <button type="submit" class="btn btn-success" id="mdBtAddProductToList">Add</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection






