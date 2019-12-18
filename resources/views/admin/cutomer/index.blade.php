@extends('layouts.admin-master')

@section('title')
    Manage Customers
@endsection




{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/customer/customer_overview.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Manage Cutomers</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Customers</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Customers Overview</h2>
                <p class="section-lead">
                    Full system Customers overview is shown here. You can edit, delete, deactivate Customers from here.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{Route('customer.create')}}" class="btn btn-success">Add New Customer</a>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-striped table-hover table-sm">
                                        <thead>
                                        <tr>
                                            <th>Customer ID</th>
                                            <th>Full Name</th>
                                            <th>NIC</th>
                                            <th>DOB</th>
                                            <th>Mobile</th>
                                            <th>Fixed</th>
                                            <th>Address</th>
                                            <th>status</th>
                                            <th>actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($customers as $customer)
                                            <tr>
                                                <td>{{$customer->ID}}</td>
                                                <td>{{$customer->fullName}}</td>
                                                <td>
                                                    <a href="{{Route('customer.show',['id'=>$customer->ID])}}">{{$customer->NIC}}</a>
                                                </td>
                                                <td>{{$customer->DOB}}</td>
                                                <td>{{$customer->mobile}}</td>
                                                <td>{{$customer->fixed}}</td>
                                                <td>{{$customer->address}}</td>
                                                <td>
                                                    @if($customer->status == 0)
                                                        <label class="badge badge-info">On hold</label>
                                                    @else
                                                        <label class="badge badge-success">Approved</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-center">

                                                        <button type="button"
                                                                class="btn btn-icon text-info btn-sm"><i
                                                                class="fas fa-edit"></i>
                                                        </button>
                                                        @can('delete',$customer)
                                                            <button type="button" id="btn_delete_customer"
                                                                    class="btn btn-icon text-danger btn-sm"><i
                                                                    class="fas fa-trash"></i></button>
                                                        @endcan
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
@endsection
