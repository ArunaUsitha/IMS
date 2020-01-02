@extends('layouts.admin-master')

@section('title')
    Reports Management
@endsection
{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/reports/report_management.js')}}"></script>
@endsection


@section('content')

    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Reports Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Report</a></div>
                    <div class="breadcrumb-item"><a href="#">Overview</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Report Overview</h2>
                <p class="section-lead">
                    A User can generate system reports that are provided
                </p>


                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="row container-fluid">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md" style="">
                                <div class="card-header-action">

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="row mx-auto">
                            <div class="col-12">
                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab2" data-toggle="tab"
                                           href="#userActivityReport" role="tab" aria-controls="home"
                                           aria-selected="true">User Activity Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#salesReport"
                                           role="tab" aria-controls="profile" aria-selected="false">Sales Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab2" data-toggle="tab" href="#supplierReport"
                                           role="tab" aria-controls="contact" aria-selected="false">Supplier Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab2" data-toggle="tab"
                                           href="#customerwiseReport"
                                           role="tab" aria-controls="contact" aria-selected="false">Customerwise
                                            Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab2" data-toggle="tab"
                                           href="#stockReport"
                                           role="tab" aria-controls="contact" aria-selected="false">Full Stock Report</a>
                                    </li>
                                </ul>
                                <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade show active" id="userActivityReport" role="tabpanel"
                                         aria-labelledby="home-tab2">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="UARslctUser">Select User</label>
                                                    <select class="form-control form-control-sm" id="UARslctUser">
                                                        <option value="-1">Select User</option>
                                                        @isset($users)
                                                            @foreach($users as $user){
                                                                <option value="{{$user->id}}">{{$user->first_name}}</option>
                                                            }
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-hidden">&nbsp;</label>
                                                    <button type="button" class="btn btn-icon btn-primary btn-sm btnGenUAReport" value="print"><i class="fas fa-2x fa-print"> Print</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-danger btn-sm btnGenUAReport" value="pdf"><i class="far fa-file-pdf"> PDF</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-success btn-sm btnGenUAReport" value="excel"><i class="far fa-file-excel"> Excel</i>
                                                    </button>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="salesReport" role="tabpanel"
                                         aria-labelledby="profile-tab2">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="SRFromDate">From</label>
                                                    <input type='text' class="form-control form-control-sm datepicker"
                                                           id="SRFromDate"
                                                           name="SRFromDate">

                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label for="SRToDate">To</label>
                                                    <input type='text' class="form-control form-control-sm datepicker"
                                                           id="SRToDate"
                                                           name="SRToDate">

                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-hidden">&nbsp;</label>

                                                    <button type="button" class="btn btn-icon btn-primary btn-sm btnGenSalesReport" value="print"><i class="fas  fa-print"> Print</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-danger btn-sm btnGenSalesReport" value="pdf"><i class="far fa-file-pdf"> PDF</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-success btn-sm btnGenSalesReport" value="excel"><i class="far fa-file-excel"> Excel</i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="supplierReport" role="tabpanel"
                                         aria-labelledby="contact-tab2">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="SRslctSupplier">Select Supplier</label>
                                                    <select class="form-control form-control-sm" id="SRslctSupplier">
                                                        <option value="-1">Select Supplier</option>
                                                        @isset($suppliers)
                                                            @foreach($suppliers as $supplier){
                                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                            }
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-hidden">&nbsp;</label>
                                                    <button type="button" class="btn btn-icon btn-primary btn-sm btnGenSReport" value="print"><i class="fas fa-print"> Print</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-danger btn-sm btnGenSReport" value="pdf"><i class="far fa-file-pdf"> PDF</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-success btn-sm btnGenSReport" value="excel"><i class="far fa-file-excel"> Excel</i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="customerwiseReport" role="tabpanel"
                                         aria-labelledby="contact-tab2">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label for="SRslctSupplier">Select Customer</label>
                                                    <select class="form-control form-control-sm" id="SRslctCustomer">
                                                        <option value="-1">Select Customer</option>
                                                        @isset($customers)
                                                            @foreach($customers as $customer){
                                                            <option value="{{$customer->id}}">{{$customer->first_name}}</option>
                                                            }
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label class="label-hidden">&nbsp;</label>
                                                    <button type="button" class="btn btn-icon btn-primary btn-sm btnGenCWReport" value="print"><i class="fas fa-print"> Print</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-danger btn-sm btnGenCWReport" value="pdf"><i class="far fa-file-pdf"> PDF</i>
                                                    </button>
                                                    <button type="button" class="btn btn-icon btn-success btn-sm btnGenCWReport" value="excel"><i class="far fa-file-excel"> Excel</i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="stockReport" role="tabpanel"
                                         aria-labelledby="contact-tab2">
                                        <button type="button" class="btn btn-icon btn-primary btn-sm btnGenStockReport" value="print"><i class="fas fa-print"> Print</i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-danger btn-sm btnGenStockReport" value="pdf"><i class="far fa-file-pdf"> PDF</i>
                                        </button>
                                        <button type="button" class="btn btn-icon btn-success btn-sm btnGenStockReport" value="excel"><i class="far fa-file-excel"> Excel</i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </div>
        </div>
    </section>


@endsection






