@extends('layouts.admin-master')

@section('title')
   Supplier Order History
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/supplier/order_history.js')}}"></script>
@endsection

@section('css')
{{--    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/user/user_index.css')}}">--}}
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Supplier Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Suppliers</a></div>
                    <div class="breadcrumb-item"><a href="#">Order History</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Supplier Order History</h2>
                <p class="section-lead">
                    Full list of invoices that are purhchased
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
{{--                                <div class="card-header-action">--}}
{{--                                    --}}{{--                                    @can('create',Auth::user())--}}
{{--                                    <a href="{{Route('user.create')}}" class="btn btn-success float-right">Add New--}}
{{--                                        User</a>--}}
{{--                                    --}}{{--                                    @endcan--}}
{{--                                </div>--}}
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">


                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblSupplierHistory">
                                        <thead>
                                        <tr>
                                            <th>#</th>
{{--                                            <th>Purchase ID</th>--}}
                                            <th>Supplier</th>
                                            <th>Product Code</th>
                                            <th>Quantity</th>
                                            <th>Buy Price</th>
                                            <th>Sell Price</th>
                                            <th>Profit Percentage</th>
                                            <th>Profit type</th>
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


    {{--    modals--}}
{{--    <div class="modal fade" tabindex="-1" role="dialog" id="mdUserEdit" style="display: none;" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-md modal-dialog-centered " role="document">--}}
{{--            <div class="modal-content">--}}

{{--                <div class="card card-warning">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4>Quick Edit User <strong class="text-warning"><span id="mdUsername"></span> </strong></h4>--}}
{{--                    </div>--}}
{{--                    <form id="mdFrmUserQuickUpdate">--}}
{{--                        <div class="card-body">--}}
{{--                            <input type="hidden" name="userID" id="mdUserID">--}}
{{--                            <div class="form-group">--}}
{{--                                <div class="control-label">Set User State</div>--}}
{{--                                <label class="custom-switch mt-2">--}}

{{--                                    <input type="checkbox" value="1" name="userStatus" id="MdChkUserStatus"--}}
{{--                                           class="custom-switch-input">--}}

{{--                                    <span class="custom-switch-indicator"></span>--}}
{{--                                    <span class="custom-switch-description">Activate/Deactivate User</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}


{{--                            <div class="form-group">--}}
{{--                                <label for="MdSlctUserType">Set User Type</label>--}}
{{--                                <select type="text" class="form-control form-control-sm" id="MdSlctUserType"--}}
{{--                                        name="userType">--}}
{{--                                    <option value="-1">Select title</option>--}}
{{--                                    @foreach($roles as $role)--}}

{{--                                        <option value="{{$role->name}}"> {{$role->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <span class="float-left">--}}
{{--                                <a id="mdAdvRoute" href="{{Route('user.edit')}}">Advanced</a>--}}
{{--                            </span>--}}
{{--                            <span class="float-right">--}}
{{--                            <button type="submit" class="btn btn-success" id="mdBtUpdateUser">Update</button>--}}

{{--                                </span>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}


{{--        </div>--}}
{{--    </div>--}}

@endsection
