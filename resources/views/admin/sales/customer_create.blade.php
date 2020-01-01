@extends('layouts.admin-master')

@section('title')
    Register New Customer
@endsection

{{--load custom css--}}
@section('css')

@endsection


{{--load js--}}
@section('js')
    @isset($customers)
        <script src="{{URL::asset('app/js/sales/customer_update.js')}}"></script>
    @else()
        <script src="{{URL::asset('app/js/sales/customer_create.js')}}"></script>
    @endisset()

@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Sales Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Sales</a></div>
                <div class="breadcrumb-item"><a href="#">{{isset($customers) ? 'Update ' : 'Register '}} Customer</a>
                </div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">{{isset($customers) ? 'Update ' : 'Register '}} Customer</h2>
            <p class="section-lead">
                @isset($customers)
                    {{'A selected customer can be updated here.'}}
                @else
                    {{' A new Customer can be registered here.'}}
                @endisset()

            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="{{Route('sales.customerOverview')}}" class="btn btn-primary">View All Registered Customers</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="" id="frmCustomerRegister" method="post">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">
                                    @isset($customers)
                                        <input type="hidden" name="customer_id" value="{{$customers->id}}">
                                    @endisset()
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <select type="text" class="form-control form-control-sm" id="title"
                                                    name="title">
                                                <option value="-1">Select title</option>
                                                <option
                                                    {{isset($customers) && $customers->title == 'Mr' ? 'selected' : ''}}  value="Mr">
                                                    Mr
                                                </option>
                                                <option
                                                    {{isset($customers) && $customers->title == 'Mrs' ? 'selected' : ''}} value="Mrs">
                                                    Mrs
                                                </option>
                                                <option
                                                    {{isset($customers) && $customers->title == 'Miss' ? 'selected' : ''}}value="Miss">
                                                    Miss
                                                </option>

                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="initials">Initials</label>
                                            <input type="text" class="form-control form-control-sm" id="initials"
                                                   name="initials"
                                                   placeholder="Intials of customers's name ex: A. B"
                                                   value="{{isset($customers)?$customers->initials : ''}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" class="form-control form-control-sm" id="first_name"
                                                   name="first_name"
                                                   placeholder="First Name"
                                                   value="{{isset($customers)?$customers->first_name : ''}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" class="form-control form-control-sm" id="last_name"
                                                   name="last_name"
                                                   placeholder="Last Name"
                                                   value="{{isset($customers)?$customers->last_name : ''}}">
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block">Gender</label>

                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender1" name="gender"
                                                       class="custom-control-input"
                                                       value="m" {{isset($customers) && $customers->gender === 'm' ? 'checked' :''}}>
                                                <label class="custom-control-label" for="gender1">Male</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gender2" name="gender"
                                                       class="custom-control-input"
                                                       value="f" {{isset($customers) && $customers->gender === 'f' ? 'checked' :''}}>
                                                <label class="custom-control-label" for="gender2">Female</label>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-6">

                                        <div class="form-group">
                                            <label for="mobile">Mobile No</label>
                                            <input type="text" class="form-control form-control-sm" id="mobile"
                                                   placeholder="Mobile Number" name="mobile"
                                                   value="{{isset($customers)?$customers->mobile : ''}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="address_no">House No</label>
                                            <input type="text" class="form-control form-control-sm" id="address_no"
                                                   placeholder="Address"
                                                   name="address_no"
                                                   value="{{isset($customers)?$customers->address_no : ''}}">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_street">Street</label>
                                            <input type="text" class="form-control form-control-sm" id="address_street"
                                                   placeholder="Address"
                                                   name="address_street"
                                                   value="{{isset($customers)?$customers->address_street : ''}}">
                                        </div>


                                        <div class="form-group">
                                            <label for="address_city">City</label>
                                            <input type="text" class="form-control form-control-sm" id="address_city"
                                                   placeholder="Address"
                                                   name="address_city"
                                                   value="{{isset($customers)?$customers->address_city : ''}}">
                                        </div>


                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control form-control-sm" id="email"
                                                   placeholder="Email" name="email"
                                                   value="{{isset($customers)?$customers->email : ''}}">
                                        </div>


                                        <span class="float-right">
                                        <button type="submit" class="btn btn-success" id="bt_submit">{{isset($customers)? 'Update ': 'Save '}} Customer</button>
                                            @isset($customers)
                                            @else()
                                                <button id="clearForm" type="button"
                                                        class="btn btn-warning">Clear</button>
                                            @endisset()
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

