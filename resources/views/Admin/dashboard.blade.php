@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow feedback border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Businesses</h5>
                    <h1 class="display-4">{{ $businessCount }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
