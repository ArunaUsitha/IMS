@extends('layouts.admin-master')

@section('title')
    Create Product
@endsection

{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/product/product_create.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Product</a></div>
                <div class="breadcrumb-item"><a href="#">Add New Product</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Add New Product</h2>
            <p class="section-lead">
                A new Product can be Added.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#mdCreateBrand">Add New
                            Brand</a>
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#mdCreateCategory">Add New
                            Category</a>
                        <a href="{{Route('product.overview')}}" class="btn btn-primary">Product Overview</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmCreateProduct" method="post">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-6">

                                        <div class="form-group">
                                            <label for="product_code">Product Code</label>
                                            <div class="input-group mb-3">

                                                <input type="text" class="form-control form-control-sm" id="product_code"
                                                       name="product_code" readonly
                                                       placeholder="Click the refresh button on the right to get new code">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success btn-sm" id="btnGetNewProductCode" data-toggle="tooltip" data-placement="top" title="" data-original-title="Get New Prodcut Code"  type="button"><i class="fas fa-sync-alt"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="c_product_code">Custom Product Code</label>
                                            <input type="text" class="form-control form-control-sm" id="c_product_code"
                                                   name="c_product_code"
                                                   placeholder="category - brand name - model ">
                                        </div>

                                        <div class="form-group">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="form-control form-control-sm" id="product_name"
                                                   name="product_name"
                                                   placeholder="Name of the product">
                                        </div>

                                        <div class="form-group">
                                            <label for="p_category">Product Category</label>
                                            <select class="form-control form-control-sm" id="p_category_id"
                                                    name="p_category_id">
                                                <option value="-1">Select Option</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="brand_id">Brand Name</label>
                                            <select class="form-control form-control-sm" id="brand_id"
                                                    name="brand_id">
                                                <option value="-1">Select Option</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="model_no">Model No</label>
                                            <input type="text" class="form-control form-control-sm" id="model_no"
                                                   name="model_no"
                                                   placeholder="Model No/Part No">
                                        </div>


                                        <div class="form-group">
                                            <label for="descrip">Description</label>
                                            <textarea class="form-control form-control-sm" id="descrip"
                                                      name="descrip"
                                                      placeholder="Product Description"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="reorder_point">Reorder Point</label>
                                            <input type="number" class="form-control form-control-sm" id="reorder_point"
                                                   name="reorder_point" value="0"
                                                   placeholder="Reorder point before out of stock">
                                        </div>

                                        <div class="form-group">
                                            <label for="reorder_quantity">Reorder Quantity</label>
                                            <input type="number" class="form-control form-control-sm"
                                                   id="reorder_quantity"
                                                   name="reorder_quantity" value="0"
                                                   placeholder="Quantity to reorder">
                                        </div>


                                        <div class="form-group">
                                            <div class="control-label">Product Status</div>
                                            <label class="custom-switch mt-2">

                                                <input type="checkbox" value="1" name="productStatus"
                                                       id="MdChkProdcutStatus"
                                                       class="custom-switch-input">

                                                <span class="custom-switch-indicator"></span>
                                                <span
                                                    class="custom-switch-description">Activate/Deactivate Product</span>
                                            </label>
                                        </div>


                                        <span class="float-right">
                                            <button type="submit" class="btn btn-success"
                                                    id="bt_submit">Create Product</button>
                                            <button id="clearForm" type="button" class="btn btn-warning">Clear</button>
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


    {{--    modals--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="mdCreateBrand" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Add New Brand</h4>
                    </div>
                    <form id="mdFrmAddBrand">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="brand_name"
                                       name="brand_name"
                                       placeholder="Brand Name">
                            </div>

                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtSaveBrand">Save Brand</button>
                             <button id="clearFormMdCreateBrand" type="button" class="btn btn-warning">Clear</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="mdCreateCategory" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Add New Category</h4>
                    </div>
                    <form id="mdFrmAddCategory">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="category_name">Category Name</label>
                                <input type="text" class="form-control form-control-sm"
                                       id="category_name"
                                       name="category_name"
                                       placeholder="Category Name">
                            </div>


                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtCreateCategory">Save Category</button>
                             <button id="clearFormMdCreateCategory" type="button" class="btn btn-warning">Clear</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
