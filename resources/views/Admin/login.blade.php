@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="d-flex flex-column justify-content-center">
            <div class="row d-flex flex-column justify-content-center flex-column">
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold primary-text ms-5">Hi, welcome back</h1>
                    <p class="text-center fw-semibold">Please fill in your details to log in</p>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-body dw-th">
                    <form method="POST" action="{{ route('admin.login') }}" class="form-group">
                        {{ csrf_field() }}
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

                        <div class="mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary btn-custom">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="mt-3 text-center">
                Don't have an account ? <span class="primary-text fw-bold">
                    <a class="text-decoration-none" href="{{ route('register') }}"><span class="primary-text fw-bold">Sign
                            up</span></a>
                </span>
                <br><br>
                <small>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</small>
            </p>
        </div>
    </div>
@endsection
