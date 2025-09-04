@php
    $primary_role = strtolower(auth()->user()->primary_role);
    $layout = $primary_role === 'super_admin' ? 'layouts.admin' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Edit user')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-cancel">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <div class="row">
            <div class="col-8">
                <div class="card card-shadow feedback">
                    <div class="card-top">
                        <h2 class="primary-text ms-5 mt-2">Edit users</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.updateUser', ['id' => $user->id]) }}"
                            class="form-group m-5 mt-2">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="text" class="form-control"
                                    value="{{ old('email', $user->email) }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="role" class="form-label">Role</label>
                                {!! Form::select('role_id', getBusinessRoles($user->business_id), null, ['class' => 'form-control']) !!}
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="form-label">New password</label>
                                <input id="password" name="password" type="password" class="form-control" autofocus>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password_confirmation" class="form-label">Confirm password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" autofocus>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-custom">
                                        Update
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
