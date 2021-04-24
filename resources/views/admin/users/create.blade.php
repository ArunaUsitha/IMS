@extends('layouts.admin-master')

@section('title')
    Add User
@endsection

{{--load custom css--}}
@section('css')

@endsection


{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/user/user_reg.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>User Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Users</a></div>
                <div class="breadcrumb-item"><a href="#">Add User</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Add new User</h2>
            <p class="section-lead">
                A new user can be created here to use the system.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{Route('user.overview')}}" class="btn btn-primary">View All Users</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmUserRegister" method="post">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <select type="text" class="form-control form-control-sm" id="title"
                                                    name="title">
                                                <option value="-1">Select title</option>
                                                <option value="Mr">Mr</option>
                                                <option value="Mrs">Mrs</option>
                                                <option value="Miss">Miss</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="initials">Initials</label>
                                            <input type="text" class="form-control form-control-sm" id="initials"
                                                   name="initials"
                                                   placeholder="Intials of user's name ex: A. B">
                                        </div>

                                        <div class="form-group">
                                            <label for="initials_full">Initials in Full</label>
                                            <input type="text" class="form-control form-control-sm" id="initials_full"
                                                   name="initials_full"
                                                   placeholder="Describe initials">
                                        </div>

                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control form-control-sm" id="first_name"
                                                   name="first_name"
                                                   placeholder="First Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" id="last_name"
                                                   name="last_name"
                                                   placeholder="Last Name">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Gender</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender1" name="gender"
                                                       class="custom-control-input" value="m">
                                                <label class="custom-control-label" for="gender1">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender2" name="gender"
                                                       class="custom-control-input" value="f">
                                                <label class="custom-control-label" for="gender2">Female</label>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="mobile">Mobile No</label>
                                            <input type="text" class="form-control form-control-sm" id="mobile"
                                                   placeholder="Mobile Number" name="mobile">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_no">House No</label>
                                            <input type="text" class="form-control form-control-sm" id="address_no"
                                                   placeholder="Address"
                                                   name="address_no">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_street">Street</label>
                                            <input type="text" class="form-control form-control-sm" id="address_street"
                                                   placeholder="Address"
                                                   name="address_street">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_city">City</label>
                                            <input type="text" class="form-control form-control-sm" id="address_city"
                                                   placeholder="Address"
                                                   name="address_city">
                                        </div>


                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="birthday">Date of birth</label>
                                            <input type='text' class="form-control form-control-sm datepicker"
                                                   id="birthday"
                                                   name="birthday">

                                        </div>


                                        <div class="form-group">
                                            <label for="nic">NIC No</label>
                                            <input type="text" class="form-control form-control-sm" id="nic"
                                                   placeholder="NIC No" name="nic">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                   placeholder="Email" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password"
                                                   placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label for="passwordConf">Confirm Password</label>
                                            <input type="password" class="form-control form-control-sm"
                                                   id="passwordConf"
                                                   placeholder="Password">
                                        </div>

                                        <div class="form-group">
                                            <label for="profile_img" class="custom-file-upload">
                                                <i class="text-danger fas fa-cloud-upload-alt"></i> User Image
                                            </label>
                                            <input id="profile_img" name='profile_img' class="file-upload" type="file">
                                        </div>

                                        <div class="form-group">
                                            <label for="role_id">User Role</label>
                                            <select type="text" class="form-control form-control-sm" id="role_id"
                                                    name="role_id">
                                                <option value="-1">Select title</option>
                                                @foreach($roles as $role)
                                                    <option value=" {{$role->name}}"> {{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <span class="float-right">
                            <button type="submit" class="btn btn-success" id="bt_submit">Save User</button>
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
@endsection
