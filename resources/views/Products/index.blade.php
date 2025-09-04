@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-end mt-3 mb-3">
            @if (auth()->user()->role && auth()->user()->role->isStaff())
                <a class="btn btn-primary me-2 btn-custom" href="{{ route('products.create') }}">
                    ➕ New
                </a>
            @endif
            <button class="btn btn-primary btn-custom" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-filter" viewBox="0 0 16 16">
                    <path
                        d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
        </div>
        <div class="row">
            @foreach ($products as $p)
                <div class="col-md-3 mb-4 d-flex">
                    <div class="card product-card flex-fill">
                        <!-- Image container with overlay -->
                        <div class="image-container">
                            <img src="{{ asset('storage/products/' . $p->image) }}" alt="{{ $p->name }}">
                            <div class="product-description scrollbar">
                                {{ $p->description }}
                            </div>
                        </div>
                        <!-- Info section (not covered by overlay) -->
                        <div class="product-info">
                            <h5 class="card-title scrollbar">{{ $p->name }}</h5>
                            <p class="card-text">${{ number_format($p->price, 2) }}</p>

                            @if (auth()->user()->role && auth()->user()->role->isCustomer())
                                <form method="POST" action="{{ route('cart.add') }}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                                    <button type="submit" class="btn btn-primary btn-custom">Add to Cart</button>
                                </form>
                            @elseif (auth()->user()->role && auth()->user()->role->isStaff())
                                <p class="card-text">{{ number_format($p->stock) }} items remaining</p>
                                <div class="d-flex justify-content-center">
                                    <a class="btn p-0 m-0 me-2" href="{{ route('products.edit', $p->id) }}">
                                        📝
                                    </a>
                                    <form id="delete-form-{{ $p->id }}"
                                        action="{{ route('products.destroy', $p->id) }}" method="POST" class="m-0 p-0">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" class="btn p-0 m-0  btn-delete"
                                            data-id="{{ $p->id }}" style="font-size: 0.9em;">
                                            🗑
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $products->links() }}
        </div>

    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Filter</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('products.filter') }}" method="POST">
                {{ csrf_field() }}
                <div class="mb-3">
                    <label for="product name" class="form-label">Product name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="name"
                        placeholder="Product name">
                    <div id="name" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="Price" class="form-label">Product price</label>
                    <input type="number" class="form-control" id="Price" name="price" aria-describedby="price"
                        placeholder="Product price">
                    <div id="name" class="form-text"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-custom">Filter</button>
            </form>
        </div>
    </div>
@endsection
