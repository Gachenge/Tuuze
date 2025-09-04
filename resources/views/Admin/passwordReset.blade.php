@extends('layouts.admin')

@section('title', 'Reset password')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('admin.business') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-shadow feedback">
                    <div class="card-top">
                        <h2 class="primary-text ms-5 mt-2">Reset password</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.resetPassword', $id) }}" class="form-group m-5 mt-2">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="form-label">New password</label>
                                <input id="password" name="password" type="password" class="form-control" required
                                    autofocus>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="form-label">Confirm password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" required autofocus>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-custom">
                                        Reset
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
