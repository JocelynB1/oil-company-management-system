@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <product-sales-per-date></product-sales-per-date>
                        </div>

                        <div class="col-md-6">
                            <product-sales-per-type></product-sales-per-type>
                        </div>
                    </div>
                    <div class="row">
                        <outstanding-inventory></outstanding-inventory>
                    </div>     

                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                You are logged in!
            </div>
        </div>
    </div>
</div>

@endsection
