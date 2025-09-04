@extends ('layouts.app')

@section('title', 'Dashboard')

@php
    $user = auth()->user()->load('role');
    $isStaff = $user->role ? $user->role->isStaff() : false;
@endphp

@section('content')

    <div class="container mt-4 scrollbar">
        <h2 class="primary-text mb-2 mt-2">Orders</h2>
        <h5 class="text-end">Total Purchase Cost: {{ $allOrders['totalCost'] }}</h4>
            @php
                $myOrders = $allOrders['myorders'];
            @endphp
            @foreach ($myOrders as $order)
                <div class="card mb-4">
                    <div class="card-header">
                        Order #{{ $order->id }} — Total: {{ number_format($order->total, 2) }}
                        @if ($isStaff)
                            @php
                                $customer = $order->user;
                            @endphp
                            <div class="text-end">
                                Customer: {{ $customer->name }}
                                <div class="font-italic">
                                    {{ $customer->email }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($item->product->name, 20, '...') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 2) }}</td>
                                        <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach

            {{-- Pagination links --}}
            <div class="mt-4 d-flex justify-content-end">
                {{ $myOrders->links() }}
            </div>

    </div>

@endsection
