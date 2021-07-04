@extends('layouts.admin-master')

@section('title')
    Supplier Overview
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/supplier/supplier_overview.js')}}"></script>
@endsection

@section('css')
    {{--    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/supplier/supplier_overview.css')}}">--}}
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Supplier Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Suppliers</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Supplier Overview</h2>
                <p class="section-lead">
                    Full list of suppliers who are registered with the system can be seen here. Supplier Active status
                    and Approved status can also be seen here.
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
                                        <a href="{{Route('supplier.create')}}" class="btn btn-success float-right">Add
                                            New
                                            Supplier</a>
{{--                                    @endcan--}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">


                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblSupplierOverview">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Company Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Fixed</th>
                                            <th>Status</th>
                                            <th>Approved</th>
                                            <th>Added on</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($suppliers as $supplier)
                                            <tr>
                                                <td>{{$supplier->id}}</td>
                                                <td>{{$supplier->name}}</td>
                                                <td>{{$supplier->company_name}}</td>
                                                <td>{{$supplier->email}}</td>
                                                <td>{{$supplier->address}}</td>
                                                <td>{{$supplier->mobile}}</td>
                                                <td>{{$supplier->fixed}}</td>

                                                <td>
                                                    @switch($supplier->status)
                                                        @case(0)
                                                        <label class="badge badge-danger">Deactive</label>
                                                        @break;
                                                        @case(1)
                                                        <label class="badge badge-success">Active</label>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @switch($supplier->is_approved)
                                                        @case(0)
                                                        <label class="badge badge-danger">Pending Approval</label>
                                                        @break;
                                                        @case(1)
                                                        <label class="badge badge-success">Approved</label>
                                                    @endswitch
                                                </td>
                                                <td>{{$supplier->created_at}}</td>

                                                <td>
                                                    <span class="text-center">
{{--                                                        @can('read',Auth::user())--}}
                                                            <button type="button"
                                                                    onclick="window.location='edit?id={{$supplier->id}}'"
                                                                    class="btn btn-icon text-success btn-sm"
                                                                    data-toggle="tooltip" data-placement="top" title=""
                                                                    data-original-title="Advance View"><i
                                                                    class="fas fa-search-plus"></i></button>
{{--                                                        @endcan--}}
{{--                                                        @can('update',Auth::user())--}}
                                                            <button type="button" value="{{$supplier->id}}"
                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title=""
                                                                    data-original-title="Quick Edit"><i
                                                                    class="fas fa-edit"></i>
                                                        </button>
{{--                                                        @endcan--}}

                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
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



    {{--    modals--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="mdSupplierEdit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Quick Edit Supplier <strong class="text-warning"><span id="mdUsername"></span> </strong></h4>
                    </div>
                    <form id="mdFrmSupplierQuickUpdate">
                        <div class="card-body">
                            <input type="hidden" name="supplierID" id="mdSupplierID">
                            <p class="text-warning">Once a supplier is approved it cannot be reversed. Deactivations only.</p>
                            <div class="form-group" id="frmGrpSupplierApprove">
                                <div class="control-label">Approve Supplier</div>

                                <label class="custom-switch mt-2">

                                    <input type="checkbox" value="1" name="supplierApprove" id="mdChkSupplierApprove"
                                           class="custom-switch-input">

                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Approve Supplier</span>

                                </label>

                            </div>


                            <div class="form-group">
                                <div class="control-label">Set Supplier State</div>
                                <label class="custom-switch mt-2">

                                    <input type="checkbox" value="1" name="supplierStatus" id="mdChkSupplierStatus"
                                           class="custom-switch-input">

                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Activate/Deactivate Supplier</span>
                                </label>
                            </div>


                            <span class="float-left">
                                <a id="mdAdvRoute" href="{{Route('supplier.edit')}}">Advanced</a>
                            </span>
                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtUpdateSupplier">Update</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>




@endsection
