@extends('layouts.admin')

@section('title', 'Add business')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('admin.business') }}" class="btn btn-outline-secondary btn-cancel">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-shadow feedback">
                    <div class="card-top">
                        <h2 class="primary-text ms-5 mt-2">Add business</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.addBusiness') }}" class="form-group m-5 mt-2"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <div class="mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control"
                                    value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('initials') ? ' has-error' : '' }}">
                                <label for="initials" class="form-label">Initials</label>
                                <input id="initials" name="initials" type="text" class="form-control"
                                    value="{{ old('initials') }}" required autofocus>
                                @if ($errors->has('initials'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('initials') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="form-label">E-Mail Address</label>
                                <input id="email" name="email" type="email" class="form-control"
                                    value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('domain') ? ' has-error' : '' }}">
                                <label for="domain" class="form-label">Domain</label>
                                <input id="domain" type="text" class="form-control" name="domain"
                                    value="{{ old('domain') }}" required>
                                @if ($errors->has('domain'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('domain') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('logo_file') ? ' has-error' : '' }}">
                                <label for="logofile" class="form-label">Upload Logo</label>
                                <input id="logofile" type="file" class="form-control" name="logofile">
                                @if ($errors->has('logofile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logofile') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-custom">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
