@extends('layouts.admin-master')

@section('title')
    Add Customer
@endsection

{{--load custom css--}}
@section('css')
    <link rel="stylesheet" href="{{URL::asset('assets/vendors/bootstrap-daterange-picker/daterangepicker.css')}}">
@endsection


{{--load js--}}
@section('js')
    <script src="{{URL::asset('assets/vendors/bootstrap-daterange-picker/daterangepicker.js')}}"></script>
    <script src="{{URL::asset('app/js/customer/customer_reg.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Add Customer</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Customer</a></div>
                <div class="breadcrumb-item"><a href="#">Add Customer</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Add New Customer</h2>
            <p class="section-lead">
                A new customer is added to the system.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{Route('customer.overview')}}" class="btn btn-primary">View All Customers</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmCustomerRegister" method="post">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <select type="text" class="form-control form-control-sm" id="title"
                                                    name="title">
                                                <option value="-1">Select title</option>
                                                <option value="none">none</option>
                                                <option value="mr">Mr</option>
                                                <option value="mrs">Mrs</option>
                                                <option value="miss">Miss</option>
                                                <option value="prof">Prof</option>
                                                <option value="Dr">Dr</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="nic">Nic</label>
                                            <input type="text" class="form-control form-control-sm" id="nic"
                                                   placeholder="National ID No" name="nic">
                                        </div>
                                        <div class="form-group">
                                            <label for="initials">Initials</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="initials"
                                                   name="initials" placeholder="initials. ex: A. B">
                                        </div>

                                        <div class="form-group">
                                            <label for="initials_full">Initials in Full</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="initials_full"
                                                   name="initials_full" placeholder="Describe initials">
                                        </div>

                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="first_name"
                                                   name="first_name" placeholder="First Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="last_name"
                                                   name="last_name" placeholder="Last Name">
                                        </div>

                                    </div>
                                    <div class="col-4">

                                        <div class="form-group">
                                            <label for="DOB">Birthday</label>
                                            <input type='text' class="form-control form-control-sm datepicker"
                                                   id="DOB"
                                                   name="DOB" placeholder="Birthday">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Gender</label>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender1" name="gender" class="custom-control-input" value="m" >
                                                <label class="custom-control-label" for="gender1">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender2" name="gender" class="custom-control-input" value="f" >
                                                <label class="custom-control-label" for="gender2">Female</label>
                                            </div>

                                        </div>



                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="mobile"
                                                   name="mobile" placeholder="Mobile No">
                                        </div>



                                        <div class="form-group">
                                            <label for="fixed">Fixed</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="fixed"
                                                   name="fixed" placeholder="Fixed line no">
                                        </div>



                                        <div class="form-group">
                                            <label for="address_no">House No</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="address_no"
                                                   name="address_no" placeholder="House No">
                                        </div>

                                        <div class="form-group">
                                            <label for="address_street">Street</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="address_street"
                                                   name="address_street" placeholder="Street Name">
                                        </div>

                                    </div>
                                    <div class="col-4">


                                        <div class="form-group">
                                            <label for="address_city">City</label>
                                            <input type='text' class="form-control form-control-sm"
                                                   id="address_city"
                                                   name="address_city" placeholder="City Name">
                                        </div>





                                        <div class="form-group">
                                            <label for="profile_img" class="custom-file-upload">
                                                <i class="text-danger fas fa-cloud-upload-alt"></i> User Image
                                            </label>
                                            <input id="profile_img" name='profile_img' class="file-upload" type="file">
                                        </div>


                                        <div class="form-group">
                                            <label for="nic_img" class="custom-file-upload"> <i class="text-danger fas fa-cloud-upload-alt"></i> NIC scan copy</label>
                                            <input type='file' class="file-upload"
                                                   id="nic_img"
                                                   name="nic_img" placeholder="NIC Scan copy">
                                        </div>

                                        <div class="form-group">
                                            <label for="gs_cert_img" class="custom-file-upload"> <i class="text-danger fas fa-cloud-upload-alt"></i> GS Certificate</label>
                                            <input type='file' class="file-upload"
                                                   id="gs_cert_img"
                                                   name="gs_cert_img" placeholder="Grama Niladari Certificate">
                                        </div>





                                        <div class="form-group">
                                            <label for="j_borrow_img" class="custom-file-upload"> <i class="text-danger fas fa-cloud-upload-alt"></i> Joint Borrower
                                                image</label>
                                            <input type='file' class="file-upload"
                                                   id="j_borrow_img"
                                                   name="j_borrow_img" placeholder="Joint Borrower image">
                                        </div>

                                        <div class="form-group">
                                            <label for="marriage_cert_img" class="custom-file-upload"> <i class="text-danger fas fa-cloud-upload-alt"></i> Marriage
                                                Certificate </label>
                                            <input type='file' class="file-upload"
                                                   id="marriage_cert_img"
                                                   name="marriage_cert_img"
                                                   placeholder="Marriage Certificate Scan Copy">
                                        </div>

                                        <div class="form-group">
                                            <label for="road_map_img" class="custom-file-upload"> <i class="text-danger fas fa-cloud-upload-alt"></i> Road Map
                                                Image</label>
                                            <input type='file' class="file-upload"
                                                   id="road_map_img"
                                                   name="road_map_img"
                                                   placeholder="Road Map Image">
                                        </div>


                                    </div>



                                </div>
                                <span class="float-right">
                            <button type="submit" class="btn btn-success" id="bt_submit">Save Customer</button>
                            <button id="clearForm" type="button" class="btn btn-warning">Clear</button>
                                </span>

                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection
