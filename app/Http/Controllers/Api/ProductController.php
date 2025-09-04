<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $products = Product::where('business_id', $user->business_id)
            ->where('stock', '>', 0)->paginate();

        return response()->json([
            'status' => 'success',
            'products' => $products
        ]);
    }
}
