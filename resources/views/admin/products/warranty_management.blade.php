@extends('layouts.admin-master')

@section('title')
    Create Warranty
@endsection

{{--load js--}}
@section('js')
    <script src="{{URL::asset('app/js/product/warranty_create.js')}}"></script>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Product</a></div>
                <div class="breadcrumb-item"><a href="#">Warranty management</a></div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Warranty Management</h2>
            <p class="section-lead">
                Warranties can be managed here.
            </p>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#mdCreateBrand">Add New
                            Warranty Category</a>
                    </div>
                </div>

                <div class="card-body">
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Warranty Period (months)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @isset($warranties)
                            @foreach($warranties as $warranty)
                                <tr>
                                    <td>{{$warranty->id}}</td>
                                    <td>{{$warranty->name}}</td>
                                </tr>
                            @endforeach
                        @endisset

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>



@endsection
