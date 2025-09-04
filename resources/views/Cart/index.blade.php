@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <h2 class="mb-4">🛒 My Cart</h2>

            @if (empty($cart))
                <div class="alert alert-warning text-center no-timeout">
                    {{ session('error') ?? 'Your cart is empty.' }}
                    <div class="mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $productId => $line)
                                <tr data-product-id="{{ $productId }}">
                                    <td>{{ $line['name'] }}</td>
                                    <td class="text-center">${{ number_format($line['price'], 2) }}</td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('cart.update', $productId) }}"
                                            class="d-inline-flex auto-submit-form">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="number" name="quantity" value="{{ $line['quantity'] }}"
                                                min="1"
                                                class="form-control form-control-sm text-center me-2 cart-quantity"
                                                style="width: 70px;" data-price="{{ $line['price'] }}">
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        ${{ number_format($line['price'] * $line['quantity'], 2) }}
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('cart.remove', $productId) }}"
                                            class="d-inline">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4>Total: <span id="cart-total" class="text-success">${{ number_format($total, 2) }}</span></h4>

                    <div>
                        <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-outline-danger me-2">
                                Clear Cart
                            </button>
                        </form>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-custom">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.querySelectorAll('.cart-quantity').forEach(input => {
            let originalValue = input.value;

            input.addEventListener('focus', function() {
                originalValue = this.value;
            });
            input.addEventListener('change', function() {
                let quantity = parseInt(this.value);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    this.value = 1;
                }

                let form = this.form;
                let url = form.action;
                let token = form.querySelector('input[name="_token"]').value;

                let data = new FormData(form);
                data.set('quantity', quantity);

                fetch(url, {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            let row = form.closest('tr');
                            let subtotalCell = row.querySelector('td:nth-child(4)');
                            subtotalCell.textContent = '$' + (result.subtotal).toFixed(2);

                            document.querySelector('#cart-total').textContent = '$' + (result.total)
                                .toFixed(2);
                        } else {
                            this.value = originalValue;
                            toastr.error(result.message || 'Failed to update cart.');
                        }
                    })
                    .catch(error => {
                        this.value = originalValue;
                        toastr.error('Something went wrong.');
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endpush
