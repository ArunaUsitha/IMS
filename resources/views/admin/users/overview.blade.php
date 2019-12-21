@extends('layouts.admin-master')

@section('title')
    User Overview
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/user/user_index.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('app/css/user/user_index.css')}}">
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>User Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Users</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Users Overview</h2>
                <p class="section-lead">
                    Full system users overview is shown here. You can edit, delete, deactivate an existing user.
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
                                    @can('create',Auth::user())
                                        <a href="{{Route('user.create')}}" class="btn btn-success float-right">Add New
                                            User</a>
                                    @endcan
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">


                                <div class="table-responsive">


                                    <table class="table table-striped table-hover table-sm" id="tblUserOverview">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>DOB</th>
                                            <th>NIC</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
{{--                                        <tbody>--}}


{{--                                        @foreach($users as $user)--}}
{{--                                            <tr>--}}
{{--                                                <td>{{$user->id}}</td>--}}
{{--                                                <td>{{$user->title}} &nbsp;{{$user->initials}}--}}
{{--                                                    &nbsp;{{$user->first_name}} &nbsp;{{$user->last_name}}</td>--}}
{{--                                                <td>{{$user->address_no}} &nbsp;{{$user->address_street}}--}}
{{--                                                    &nbsp;{{$user->address_city}}</td>--}}
{{--                                                <td>{{$user->mobile}}</td>--}}
{{--                                                <td>{{$user->DOB}}</td>--}}
{{--                                                <td>{{$user->NIC}}</td>--}}
{{--                                                <td>{{$user->email}}</td>--}}
{{--                                                <td>--}}
{{--                                                    @switch($user->status)--}}
{{--                                                        @case(0)--}}
{{--                                                        <label class="badge badge-danger">Deactive</label>--}}
{{--                                                        @break;--}}
{{--                                                        @case(1)--}}
{{--                                                        <label class="badge badge-success">Active</label>--}}
{{--                                                    @endswitch--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <span class="text-center">--}}
{{--                                                        @can('read',$user)--}}
{{--                                                            <button type="button" onclick="window.location='showUser?id={{$user->id}}'"--}}
{{--                                                                    class="btn btn-icon text-success btn-sm"--}}
{{--                                                                    data-toggle="tooltip" data-placement="top" title=""--}}
{{--                                                                    data-original-title="Advance View"><i--}}
{{--                                                                    class="fas fa-search-plus"></i></button>--}}
{{--                                                        @endcan--}}
{{--                                                        @can('update',$user)--}}
{{--                                                            <button type="button" value="{{$user->id}}"--}}
{{--                                                                    class="btn btn-icon text-info btn-sm btnQuickEdit"--}}
{{--                                                                    data-toggle="tooltip" data-placement="top"--}}
{{--                                                                    title=""--}}
{{--                                                                    data-original-title="Quick Edit"><i--}}
{{--                                                                    class="fas fa-edit"></i>--}}
{{--                                                        </button>--}}
{{--                                                        @endcan--}}

{{--                                                        @can('delete',$user)--}}
{{--                                                            <button type="button"--}}
{{--                                                                    class="btn btn-icon text-warning btn-sm"--}}
{{--                                                                    data-toggle="tooltip" data-placement="top"--}}
{{--                                                                    title=""--}}
{{--                                                                    data-original-title="Delete User"><i--}}
{{--                                                                    class="fas fa-trash"></i></button>--}}
{{--                                                        @endcan--}}
{{--                                                    </span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
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
    <div class="modal fade" tabindex="-1" role="dialog" id="mdUserEdit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Quick Edit User <strong class="text-warning"><span id="mdUsername"></span> </strong></h4>
                    </div>
                    <form id="mdFrmUserQuickUpdate">
                        <div class="card-body">
                            <input type="hidden" name="userID" id="mdUserID">
                            <div class="form-group">
                                <div class="control-label">Set User State</div>
                                <label class="custom-switch mt-2">

                                    <input type="checkbox" value="1" name="userStatus" id="MdChkUserStatus"
                                           class="custom-switch-input">

                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Activate/Deactivate User</span>
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="MdSlctUserType">Set User Type</label>
                                <select type="text" class="form-control form-control-sm" id="MdSlctUserType"
                                        name="userType">
                                    <option value="-1">Select title</option>
                                    @foreach($roles as $role)

                                        <option value="{{$role->id}}"> {{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <span class="float-left">
                                <a id="mdAdvRoute" href="{{Route('user.edit')}}">Advanced</a>
                            </span>
                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtUpdateUser">Update</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

@endsection
