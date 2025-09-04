@php
    $primary_role = strtolower(auth()->user()->primary_role);
    $layout = $primary_role === 'super_admin' ? 'layouts.admin' : 'layouts.app';
@endphp

@extends($layout)

@section('title', 'Add role')

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
                        <h2 class="primary-text ms-5 mt-2">Add role</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.storeRole') }}" class="form-group m-5 mt-2">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <div class="mb-3 {{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="role_category" value="customer"
                                    id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Customer
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role_category" value="staff"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    staff
                                </label>
                                @if ($errors->has('role_category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('role_category') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="form-label">Active?</label>
                                <input id="status" name="status" type="checkbox" class="form-check" value="1"
                                    checked>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('status') }}</strong>
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
