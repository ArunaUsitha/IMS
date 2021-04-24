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

                            <div class="col-md" style="">
                                <div class="card-header-action">
                                    {{--                                    @can('create',Auth::user())--}}
{{--                                    <a class="btn btn-primary float-right" id="addModule" href="">Add New--}}
{{--                                        Module--}}
{{--                                    </a>--}}
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
                        <input type="hidden" name="role_id" id="role_id" value="{{$role->id}}">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group ml-5">
                                    <h5 class="text-success">Role : {{$role->name}}</h5>
                                </div>
                                <hr>
                            </div>

                        </div>

                        <form method="post" id="frmUpdateRolePermissions">


                        <div class="row mx-auto">


                            @foreach($permissions_list as $permission)
                                <div class="col-lg-3">


                                    <label class="custom-switch">

                                        <input type="checkbox" value="1" name="{{$permission['name']}}" id="MdChkUserStatus"
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

                                <button class="btn btn-danger float-right" type="button" id="btnSaveChanges">Save Changes</button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </section>


@endsection('content')
