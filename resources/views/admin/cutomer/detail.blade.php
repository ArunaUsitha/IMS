@extends('layouts.admin-master')

@section('title')
    {{$customer->NIC}}
@endsection

{{--load custom css--}}
@section('css_vendors')
    <link rel="stylesheet" href="{{URL::asset('assets/vendors/fancybox-master/dist/jquery.fancybox.min.css')}}">
@endsection


{{--load js--}}
@section('js_vendors')
    <script src="{{URL::asset('assets/vendors/fancybox-master/dist/jquery.fancybox.min.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="section-header">
                <h1>Customer Detail view</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Customers</a></div>
                    <div class="breadcrumb-item"><a href="#">Detail View</a></div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Customers Detail View</h2>
                <p class="section-lead">
                    Full Detail view of a selected cutomer
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4></h4>
                                <div class="card-header-action">
                                    <a href="{{Route('customer.create')}}" class="btn btn-success">Add New Customer</a>
                                    <a href="{{Route('customer.overview')}}" class="btn btn-info">View All Customers</a>

                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row justify-content-md-center">
                                    <div class=" col-md-8 col-sm-12 ">

                                            <div class="card profile-widget">
                                                <div class="profile-widget-header">
{{--                                                    <img alt="image" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" style="background-image: url('{{asset('/images/'.$customer->profile_img)}}')"  class="rounded-circle profile-widget-picture">--}}

                                                    <a href="{{asset('/images/'.$customer->profile_img)}}" data-fancybox>
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" style="background-image: url('{{asset('/images/'.$customer->profile_img)}}')" class="img-fluid rounded-circle  profile-widget-picture">
                                                    </a>


                                                    <div class="profile-widget-items">
                                                        <div class="profile-widget-item">
                                                            <div class="profile-widget-item-label">Total Loans</div>
                                                            <div class="profile-widget-item-value"><span class="badge badge-primary">10</span></div>
                                                        </div>
                                                        <div class="profile-widget-item">
                                                            <div class="profile-widget-item-label">Status</div>{!! ($customer->status) == 1 ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-danger">On hold</span>' !!}
                                                            <div class="profile-widget-item-value"></div>
                                                        </div>
                                                        <div class="profile-widget-item">
                                                            <div class="profile-widget-item-label">Approved</div>
                                                            <div class="profile-widget-item-value">{!! ($customer->approved) == 1 ? '<span class="badge badge-success">active</span>' : '<span class="badge badge-danger">On hold</span>' !!}</div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="profile-widget-description">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <P ><strong>Initials : </strong> {{$customer->initials}} </P>
                                                            <P ><strong>Initials Full : </strong> {{$customer->initials_full}} </P>
                                                            <P ><strong>Name with initials: </strong> {{$customer->initials}}&nbsp;{{$customer->first_name}}&nbsp;{{$customer->last_name}}</P>
                                                            <P ><strong>Name in full : </strong> {{$customer->initials_full}}&nbsp;{{$customer->first_name}}&nbsp;{{$customer->last_name}}</P>
                                                            <P ><strong>Birthday : </strong> {{$customer->DOB}}</P>
                                                            <P ><strong>Gender : </strong>{{($customer->gender == 'm') ? 'Male' : 'Female'}}</P>
                                                            <P ><strong>Mobile : </strong> {{$customer->mobile}}</P>
                                                            <P ><strong>Fixed : </strong> {{$customer->fixed}}</P>
                                                            <P ><strong>House No : </strong> {{$customer->address_no}}</P>
                                                            <P ><strong>Street : </strong> {{$customer->address_street}}</P>
                                                            <P ><strong>City : </strong> {{$customer->address_city}}</P>


                                                        </div>
                                                        <div class="col-6">
                                                            <a href="{{asset('/images/'.$customer->profile_img)}}" data-fancybox>Profile Image</a><br>
                                                            <a href="{{asset('/images/'.$customer->nic_img)}}" data-fancybox>NIC Image</a><br>
                                                            <a href="{{asset('/images/'.$customer->gs_cert_img)}}" data-fancybox>GS Certificate Image</a><br>
                                                            <a href="{{asset('/images/'.$customer->j_borrow_img)}}" data-fancybox>Joint Borrower Image</a><br>
                                                            <a href="{{asset('/images/'.$customer->marriage_cert_img)}}" data-fancybox>Marriage certificate Image</a><br>
                                                            <a href="{{asset('/images/'.$customer->road_map_img)}}" data-fancybox>Road map Image</a><br>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                <div class="card-footer text-center">--}}
{{--                                                    <div class="font-weight-bold mb-2">Follow Ujang On</div>--}}
{{--                                                    <a href="#" class="btn btn-social-icon btn-facebook mr-1">--}}
{{--                                                        <i class="fab fa-facebook-f"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <a href="#" class="btn btn-social-icon btn-twitter mr-1">--}}
{{--                                                        <i class="fab fa-twitter"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <a href="#" class="btn btn-social-icon btn-github mr-1">--}}
{{--                                                        <i class="fab fa-github"></i>--}}
{{--                                                    </a>--}}
{{--                                                    <a href="#" class="btn btn-social-icon btn-instagram">--}}
{{--                                                        <i class="fab fa-instagram"></i>--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
                                            </div>
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
