@extends('layouts.admin-master')

@section('title')
    User Administration
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/settings/user_administration.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/settings/user_administration.css')}}">
@endsection


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>User Administration</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item"><a href="#">User Administration</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">User Administration</h2>
                <p class="section-lead">
                    System User roles and permission changes can be made here.
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
{{--                                    <button class="btn btn-primary float-right" id="addModule">Add New--}}
{{--                                        Module--}}
{{--                                    </button>--}}
                                    {{--                                    @endcan--}}
                                    {{--                                    @can('create',Auth::user())--}}
                                    <a class="btn btn-primary float-right" id="addRole" href="{{route('settings.showCreateNewRoleView')}}">Add New
                                        User Role
                                    </a>
                                    {{--                                    @endcan--}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">


                        <div class="row mx-auto">
                            <div class="col-12">
                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblRolesOverview">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>Permissions</th>
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
        </div>
    </section>

    {{--    modals--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="msAddModule" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Add New Module</h4>
                    </div>

                    <form id="frmAddModule">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="moduleName"></label>
                                <input type="text" class="form-control form-control-sm" id="moduleName"
                                       name="moduleName">
                            </div>
                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtSaveModule">Save</button>

                                </span>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>

    {{--    modals--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="msAddUserRole" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Add New User role</h4>
                    </div>

                    <form id="frmAddUserRole">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="userRoleName"></label>
                                <input type="text" class="form-control form-control-sm" id="userRoleName"
                                       name="userRoleName">
                            </div>
                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtSaveUserRole">Save</button>

                                </span>
                        </div>
                    </form>

                </div>
            </div>


        </div>
    </div>
@endsection('content')
