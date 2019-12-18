@extends('layouts.admin-master')

@section('title')
    Edit User - {{ $user->first_name }}
@endsection

@section('js')
    <script src="{{URL::asset('app/js/user/user_edit.js')}}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{URL::asset('app/css/user/user_edit.css')}}" type="text/css">
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>User Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Users</a></div>
                <div class="breadcrumb-item"><a href="#">Edit User</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit User</h2>
            <p class="section-lead">
                User Details can be edited here.Some details may not be edited due to company policies
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="#" id="btnChangePassword" class="btn btn-danger">Change Password</a>
                        <a href="{{Route('user.overview')}}" class="btn btn-primary">View All Users</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmUserUpdate" method="post">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">

                                    <div class="col-3 align-self-center">
                                        <figure class="avatar mr-5 avatar-xl">
                                            <img src="{{asset('/images/'.$user->profile_img)}}" alt="Profile Image">
                                        </figure>
                                        <a href="#" id="btnChangeProfile" class="text-primary">Change Profile
                                            Picture</a>
                                    </div>


                                </div>
                                <hr>
                                <div class="row">


                                    <div class="col-6">
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <select type="text" class="form-control form-control-sm" id="title"
                                                    name="title">

                                                <option value="-1">Select title</option>
                                                <option value="Mr" {{($user->title) === 'Mr' ? 'selected' : ''}}>Mr
                                                </option>
                                                <option value="Mrs" {{($user->title) === 'Mrs' ? 'selected' : ''}}>Mrs
                                                </option>
                                                <option value="Miss" {{($user->title) === 'Miss' ? 'selected' : ''}}>
                                                    Miss
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="initials">Initials</label>
                                            <input type="text" class="form-control form-control-sm" id="initials"
                                                   name="initials" value="{{$user->initials}}"
                                                   placeholder="Intials of user's name ex: A. B">
                                        </div>

                                        <div class="form-group">
                                            <label for="initials_full">Initials in Full</label>
                                            <input type="text" class="form-control form-control-sm" id="initials_full"
                                                   name="initials_full" value="{{$user->initials_full}}"
                                                   placeholder="Describe initials">
                                        </div>

                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control form-control-sm" id="first_name"
                                                   name="first_name" value="{{$user->first_name}}"
                                                   placeholder="First Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" id="last_name"
                                                   name="last_name" value="{{$user->last_name}}"
                                                   placeholder="Last Name">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Gender</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender1" name="gender"
                                                       class="custom-control-input"
                                                       value="m" {{($user->gender) === 'm' ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="gender1">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender2" name="gender"
                                                       class="custom-control-input"
                                                       value="f" {{($user->gender) === 'f' ? 'checked' : ''}}>
                                                <label class="custom-control-label" for="gender2">Female</label>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Mobile No</label>
                                            <input type="text" class="form-control form-control-sm" id="mobile"
                                                   value="{{$user->mobile}}"
                                                   placeholder="Mobile Number" name="mobile">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="address_no">House No</label>
                                            <input type="text" class="form-control form-control-sm" id="address_no"
                                                   value="{{$user->address_no}}"
                                                   placeholder="Address"
                                                   name="address_no">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_street">Street</label>
                                            <input type="text" class="form-control form-control-sm" id="address_street"
                                                   value="{{$user->address_street}}"
                                                   placeholder="Address"
                                                   name="address_street">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_city">City</label>
                                            <input type="text" class="form-control form-control-sm" id="address_city"
                                                   value="{{$user->address_city}}"
                                                   placeholder="Address"
                                                   name="address_city">
                                        </div>


                                        <div class="form-group">
                                            <label for="birthday">Date of birth</label>
                                            <input type='text' class="form-control form-control-sm datepicker"
                                                   value="{{$user->DOB}}"
                                                   id="birthday"
                                                   name="birthday">

                                        </div>


                                        <div class="form-group">
                                            <label for="nic">NIC No</label>
                                            <input type="text" class="form-control form-control-sm" id="nic"
                                                   value="{{$user->NIC}}"
                                                   placeholder="NIC No" name="nic">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                   value="{{$user->email}}"
                                                   placeholder="Email" name="email">
                                        </div>

                                        <div class="form-group">
                                            <label for="role_id">User Role</label>
                                            <select type="text" class="form-control form-control-sm" id="role_id"
                                                    name="role_id">
                                                <option value="-1">Select title</option>
                                                @foreach($roles as $role)
                                                    <option
                                                        value=" {{$role->id}}" {{($user->role_id) === $role->id ? 'selected' : ''}}> {{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <span class="float-right">
                            <button type="submit" class="btn btn-success" id="bt_update">Update</button>
{{--                            <button id="clearForm" type="button" class="btn btn-warning">Clear</button>--}}
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




    <div class="modal fade" tabindex="-1" role="dialog" id="mdChangePrfilePic" style="display: none;"
         aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Change Profile Picture</h4>
                    </div>
                    <form id="mdFrmChangeProfilePic">
                        <div class="card-body">
                            <input type="hidden" name="NIC" id="NIC" value="{{$user->NIC}}">

                            <div class="form-group">
                                <label for="profile_img" class="custom-file-upload">
                                    <i class="text-danger fas fa-cloud-upload-alt"></i> User Image
                                </label>
                                <input id="profile_img" name='profile_img' class="file-upload" type="file">
                            </div>


                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtUpdateUser">Change</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" id="mdChangePassword" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="card card-warning">
                    <div class="card-header">
                        <h4>Change Password</h4>
                    </div>
                    <form id="mdFrmChangePassword">
                        <div class="card-body">
                            <input type="hidden" name="userID" id="userID" value="{{$user->id}}">

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password"
                                       value=""
                                       placeholder="password" name="password">
                            </div>

                            <div class="form-group">
                                <label for="passwordConf">Confirm Password</label>
                                <input type="password" class="form-control form-control-sm" id="passwordConf"
                                       value=""
                                       placeholder="password Confirmation" name="passwordConf">
                            </div>

                            <div class="form-group">
                                <label class="custom-switch mt-2">

                                    <input type="checkbox" value="1" name="showPass" id="chkShowPass"
                                           class="custom-switch-input">

                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">Show Passwords</span>
                                </label>
                            </div>


                            <span class="float-right">
                            <button type="submit" class="btn btn-success" id="mdBtChangePass">Change</button>

                                </span>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endsection
