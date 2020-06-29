@extends('layouts.app')

@section('content')
<section id="index-page">
    <div class="container">
        <div class="card d-block mx-auto">
            <div class="card-header">
                <img class="card-img img-responsive d-block mx-auto" src="{{asset('resources/logo/index.svg')}}">
            </div>
            <div class="card-body text-center">
                <div class="card-text">
                    <h4><b>Ubad Operational Money Management System</b></h4>
                    <p><small>login to continue</small></p>
                    <a class="btn btn-primary round-btn" href="{{ route('login') }}">{{ __('Login') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>    
@endsection