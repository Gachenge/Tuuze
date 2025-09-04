@extends('layouts.app')

@section('title', 'Add product')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-cancel">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="card card-shadow feedback">
                    <div class="card-top">
                        <h2 class="primary-text ms-5 mt-2">Add products</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('products.store') }}" class="form-group m-5 mt-2"
                            enctype="multipart/form-data">
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
                            <div class="mb-3 {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" type="text" class="form-control" required autofocus></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('imageFile') ? ' has-error' : '' }}">
                                <label for="imageFile" class="form-label">Image</label>
                                <input id="imageFile" name="imageFile" type="file" class="form-control" required
                                    autofocus>
                                @if ($errors->has('imageFile'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('imageFile') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="form-label">Price</label>
                                <input id="price" name="price" type="number" step="0.01" class="form-control"
                                    required autofocus>
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="mb-3 {{ $errors->has('stock') ? ' has-error' : '' }}">
                                <label for="stock" class="form-label">Stock</label>
                                <input id="stock" name="stock" type="number" class="form-control" required autofocus>
                                @if ($errors->has('stock'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stock') }}</strong>
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
