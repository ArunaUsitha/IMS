@extends('layouts.admin-master')

@section('title')
    User Administration
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('assets/vendors/jquery-validate/jquery.validate.js')}}"></script>
    <script src="{{URL::asset('assets/vendors/jquery-validate/additional-methods.min.js')}}"></script>
    <script src="{{URL::asset('app/js/settings/create_new_role.js')}}"></script>
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

                            <div class="col-md" style="">
                                <div class="card-header-action">
                                    {{--                                    @can('create',Auth::user())--}}
{{--                                    <button class="btn btn-primary float-right" id="addModule">Add New--}}
{{--                                        Module--}}
{{--                                    </button>--}}
                                    {{--                                    @endcan--}}
                                    {{--                                    @can('create',Auth::user())--}}

                                    {{--                                    @endcan--}}
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ml-5 col-3" id="newRoleInputDiv">
                                    <form id="frmCreateNewRole">
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <input type="text" class="form-control form-control-sm" id="role_name" name="role_name" placeholder="Enter new role name">
                                        <span class="text-info text-small">Do not put spaces, Use underscores for seperation.</span>
                                        <span class="" id="v-role-name"></span></div>
                                    </form>
                                </div>
                                <hr>
                            </div>

                        </div>

                        <form method="post" id="frmCreateRolePermissions">


                            <div class="row mx-auto">


                                @foreach($permissions as $permission)
                                    <div class="col-lg-3">


                                        <label class="custom-switch">

                                            <input type="checkbox" value="1" name="{{$permission['name']}}"
                                                   class="custom-switch-input" {{ ($permission['checked']) ? 'checked' : '' }}>

                                            <span class="custom-switch-indicator"></span>
                                            <span class="custom-switch-description">{{$permission['name']}}</span>
                                        </label>

                                    </div>
                                @endforeach


                            </div>

                        </form>

                        <div class="row">
                            <div class="col-12">

                                <button class="btn btn-danger float-right" type="button" id="btnCrateNewRole">Create Role</button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </section>


@endsection('content')
