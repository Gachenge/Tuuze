<h1>{{ $product->name }}</h1>
<p>${{ number_format($product->price, 2) }}</p>
<p>{{ $product->description }}</p>

<form method="POST" action="{{ route('cart.add') }}">
  {{ csrf_field() }}
  <input type="hidden" name="product_id" value="{{ $product->id }}">
  <button type="submit">Add to Cart</button>
</form>

<p><a href="{{ route('cart.index') }}">Go to Cart</a></p>
<p><a href="{{ route('products.index') }}">Back</a></p>
