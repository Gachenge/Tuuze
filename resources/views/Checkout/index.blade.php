@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="mb-4">💳 Checkout</h2>

            {{-- Order Summary --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    Order Summary
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        @foreach ($cart as $line)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $line['name'] }} <small class="text-muted">x {{ $line['quantity'] }}</small></span>
                                <span class="fw-bold">${{ number_format($line['price'] * $line['quantity'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <h4 class="text-end">
                        Total: <span class="text-success">${{ number_format($total, 2) }}</span>
                    </h4>
                </div>
                {{-- Checkout Form --}}
                <div class="card-footer">
                    <form method="POST" action="{{ route('checkout.store') }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success w-100 btn-custom">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
