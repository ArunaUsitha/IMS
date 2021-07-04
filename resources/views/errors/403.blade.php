@extends('layouts.auth-error')

@section('content')
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>403</h1>
                    <h3>Unauthorized!</h3>
                    <div class="page-description">
                        You do not have access to this page.
                    </div>
                    <div class="page-search">

                        <div class="mt-3">
                            <a href="{{route('dashboard')}}">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
