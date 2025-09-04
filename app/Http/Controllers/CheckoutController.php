<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $productService;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart))
        {
            return redirect()->route('cart.index')->with('error', "Your cart is empty");
        }

        $total = 0;
        foreach ($cart as $item)
        {
            $total += $item['price'] * $item['quantity'];
        }
        return view('checkout.index', compact('cart', 'total'));
    }

    public function store()
    {
        $cart = session()->get('cart', []);
        if (empty($cart))
        {
            return redirect()->route('cart.index')->with('error', "Your cart is empty");
        }

        $total = 0;
        foreach ($cart as $item)
        {
            $total += $item['price'] * $item['quantity'];
        }
        $user = auth()->user();
        $itemCount = count($cart);
        DB::transaction(function () use ($user, $cart, $total)
        {
            $order = Order::create([
                'user_id' => $user->id,
                'business_id' => $user->business_id,
                'total' => $total
            ]);

            foreach ($cart as $productId => $item)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
        });

        Notification::create([
            'receiver_id' => $user->id,
            'subject' => 'Your order has been placed',
            'message' => 'You have placed an order for ' . $itemCount . ' items, at a cost of ' . $total
        ]);

        session()->forget('cart');
        return redirect()->route('home.dashboard')->with('status', 'Order placed! check your email');
    }
}
