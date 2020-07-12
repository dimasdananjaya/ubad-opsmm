@extends('layouts.app')

@section('content')
<section id="admin-home">
    <div class="container">
        <div class="background">
            <h1 class="text-center">Admin Home</h1>
            <hr>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card d-block mx-auto">
                        <div class="card-header text-center">
                            <img style="width: 20em; height:18em;" src="{{asset('resources/logo/admin-home-kelola-dana.svg')}}">
                        </div><!--end card-header-->
                        <div class="card-body">
                            <h5 class="card-title"><b>Dana Operasional</b></h5>
                            <p class="card-text">Kelola dana operasional per-periode</p>
                            <a href="{{route('admin.pilih.periode')}}" class="btn btn-primary round-btn">Pilih</a>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->

                <div class="col-lg-6">
                    <div class="card d-block mx-auto">
                        <div class="card-header text-center">
                            <img class="card-img" src="{{asset('resources/logo/admin-home-periode.svg')}}">
                        </div><!--end card-header-->
                        <div class="card-body">
                            <h5 class="card-title"><b>Periode</b></h5>
                            <p class="card-text">Kelola data periode</p>
                            <a href="{{ route('admin.periode') }}" class="btn btn-primary round-btn">Pilih</a>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div><!--end col-->

            </div><!--end row-->
        </div><!--end card-->
    </div>
@endsection