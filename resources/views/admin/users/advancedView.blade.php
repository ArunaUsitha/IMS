@extends('layouts.admin-master')

@section('title')
    Advanced User Overview - {{ $user->first_name }}
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>User Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Users</a></div>
                <div class="breadcrumb-item"><a href="#">Advanced Overview</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Advanced User Overview</h2>
            <p class="section-lead">
                Full details of a selected user can be previewed here.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">

                        <a href="{{Route('user.overview')}}" class="btn btn-primary">View All Users</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class=" col-md-10 col-sm-12 ">

                            <div class="card profile-widget">
                                <div class="profile-widget-header">


                                    <a href="{{asset('/images/'.$user->profile_img)}}" data-fancybox="">
                                        <img
                                            src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                                            style="background-image: url({{asset('/images/'.$user->profile_img)}})"
                                            class="img-fluid rounded-circle  profile-widget-picture">
                                    </a>


                                    <div class="profile-widget-items">

                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Status</div>
                                            @if($user->status === 1)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Deactive</span>
                                            @endif

                                            <div class="profile-widget-item-value"></div>
                                        </div>

                                        <div class="profile-widget-item">

                                            <div class="profile-widget-item-label">User Role</div>
                                            <span class="badge badge-info">{{$role}}</span>
                                            <div class="profile-widget-item-value"></div>
                                        </div>


                                    </div>
                                </div>
                                <div class="profile-widget-description">
                                    <div class="row">
                                        <div class="col-6">
                                            <p><strong>Title : </strong> {{$user->title}} </p>
                                            <p><strong>Initials : </strong> {{$user->initials}} </p>
                                            <p><strong>Initials Full : </strong> {{$user->initials_full}} </p>
                                            <p><strong>Name with initials: </strong> {{$user->initials}}
                                                &nbsp;{{$user->first_name}}&nbsp;{{$user->last_name}}</p>
                                            <p><strong>Name in full : </strong> {{$user->initials_full}}
                                                &nbsp;{{$user->first_name}}&nbsp;{{$user->last_name}}</p>
                                            <p><strong>NIC : </strong> {{$user->NIC}}</p>
                                            <p><strong>Email : </strong> {{$user->email}}</p>

                                            <br>
                                            <p><strong>Created On : </strong> {{$user->created_at}}</p>
                                            <p><strong>Last Updated On : </strong> {{$user->updated_at}}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><strong>Birthday : </strong> {{$user->DOB}}</p>
                                            <p><strong>Gender
                                                    : </strong> {{($user->gender) === 'm' ? 'Male' : 'Female'}} </p>
                                            <p><strong>Mobile : </strong> {{$user->mobile}}</p>
                                            <p><strong>House No : </strong> {{$user->address_no}}</p>
                                            <p><strong>Street : </strong> {{$user->address_street}}</p>
                                            <p><strong>City : </strong> {{$user->address_city}}</p>
                                            <p><strong>Full Address : </strong>{{$user->address_no}}
                                                ,&nbsp;{{$user->address_street}},&nbsp;{{$user->address_city}},&nbsp;
                                            </p>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="accordion">
                                                <div class="accordion">
                                                    <div class="accordion-header" role="button"
                                                         data-toggle="collapse" data-target="#panel-body-1"
                                                         aria-expanded="true">
                                                        <h4>User Activity Log</h4>
                                                    </div>
                                                    <div class="accordion-body collapse show" id="panel-body-1"
                                                         data-parent="#accordion" style="">
                                                        <table class="table table-striped table-hover table-sm"
                                                               id="tblUserOverview">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Causer ID</th>
                                                                <th>Activity</th>
                                                                <th>Causer Type</th>
                                                                <th>Log Time</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach($logs as $log)
                                                                <tr>
                                                                    <td>{{$log->id}}</td>
                                                                    <td>{{$log->causer_id}}</td>
                                                                    <td>{{$log->description}}</td>
                                                                    <td>{{$log->causer_type}}</td>
                                                                    <td>{{$log->created_at}}</td>
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
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>





@endsection
