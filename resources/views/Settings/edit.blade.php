@extends('Layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="card card-shadow feedback">
                    <div class="card-top">
                        <h2 class="primary-text ms-5 mt-2">Settings</h2>
                    </div>
                    <div class="mb-3 ms-5">
                        @if ($settings->business && $settings->business->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/logos/' . $settings->business->logo) }}" alt="Logo"
                                    style="max-height: 100px;">
                            </div>
                        @endif

                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('settings.update', ['id' => $settings->id]) }}"
                            class="form-group m-5 mt-2">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="mb-3 col-8 {{ $errors->has('primary_color') ? ' has-error' : '' }}">
                                <label for="primary_color" class="form-label">Primary color</label>
                                <input id="primary_color" name="primary_color" type="color" class="form-control"
                                    value="{{ old('primary_color', $settings->primary_color) }}" autofocus>
                                @if ($errors->has('primary_color'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('primary_color') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 col-8 {{ $errors->has('secondary_color') ? ' has-error' : '' }}">
                                <label for="secondary_color" class="form-label">Secondary color</label>
                                <input id="secondary_color" name="secondary_color" type="color" class="form-control"
                                    value="{{ old('secondary_color', $settings->secondary_color) }}" autofocus>
                                @if ($errors->has('secondary_color'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('secondary_color') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row mb-0">
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary btn-custom">
                                        📝 Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
