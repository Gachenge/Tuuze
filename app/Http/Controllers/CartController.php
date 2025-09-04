<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductServiceInterface;

class CartController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->middleware('auth');
        $this->productService = $productService;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item)
        {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $data['quantity'] ?? 1;

        try
        {
            $this->productService->reduceStock($data['product_id'], $quantity);
        }
        catch (\Exception $e)
        {
            return redirect()->route('products.index')
                ->with('error', $e->getMessage());
        }

        $product = Product::findOrFail($data['product_id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id]))
        {
            $cart[$product->id]['quantity'] += $quantity;
        }
        else
        {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('products.index')->with('status', 'Added to cart');
    }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id]))
        {
            if ($request->ajax())
            {
                return response()->json(['success' => false, 'message' => 'Item not in cart'], 404);
            }
            return redirect()->route('cart.index')->with('error', 'Item not in cart');
        }

        $stock = $product->stock;
        if ($data['quantity'] > $stock)
        {
            if ($request->ajax())
            {
                return response()->json([
                    'success' => false,
                    'message' => "Only $stock $product->name remaining"
                ], 422);
            }
            return redirect()->route('cart.index')->with('error', "Only $stock remaining");
        }

        $cart[$product->id]['quantity'] = $data['quantity'];
        session()->put('cart', $cart);

        $subtotal = $cart[$product->id]['price'] * $data['quantity'];
        $total = collect($cart)->sum(function ($item)
        {
            return $item['price'] * $item['quantity'];
        });

        if ($request->ajax())
        {
            return response()->json([
                'success' => true,
                'subtotal' => $subtotal,
                'total'    => $total
            ]);
        }

        return redirect()->route('cart.index')->with('status', 'Quantity updated');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('status', 'Item removed');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('status', 'Cart cleared');
    }
}
