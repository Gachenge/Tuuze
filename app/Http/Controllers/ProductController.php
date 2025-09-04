<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\VarDumper\Cloner\Data;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $role = auth()->user()->role;
        $products = Product::orderBy('created_at', 'desc');
        if ($role->isStaff())
            $products = $products;
        else
            $products = $products->where('stock', '>', 0);
        $products = $products->paginate(12);

        return view('products.index', compact('products'));
    }
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
    public function filter(Request $request)
    {
        $query = Product::query();
        if ($request->filled('name'))
        {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('price'))
        {
            $query->where('price', '<=', $request->price);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        return view('products.index', compact('products'));
    }
    public function create()
    {
        return view('products.addProducts');
    }
    public function store(Request $request)
    {
        $businessId = auth()->user()->business_id;
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'imageFile' => 'required|file|mimes:jpeg,png,jfif|max:2048',
            'price' => 'required|numeric',
            'stock' => 'required| integer'
        ]);
        $data = [
            'name' => $request->name,
            'business_id' => $businessId,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ];

        if ($request->hasFile('imageFile'))
        {
            $file = $request->file('imageFile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('products', $file, $fileName);
            $data['image'] = $fileName;
        }
        Product::create($data);
        return redirect('products')->with('status', $data['name'] . ' added successfully');
    }
    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }
    public function update(Request $request, int $id)
    {
        $businessId = auth()->user()->business_id;
        $product = Product::where('business_id', $businessId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'imageFile' => 'nullable|file|mimes:jpeg,png,jfif|max:2048',
            'price' => 'required|numeric',
            'stock' => 'required| integer'
        ]);
        $data = [
            'name' => $request->name,
            'business_id' => $businessId,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ];
        if ($request->hasFile('imageFile'))
        {
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image))
            {
                Storage::disk('public')->delete('products/' . $product->image);
            }

            $file = $request->file('imageFile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('products', $file, $fileName);
            $data['image'] = $fileName;
        }
        $product->update($data);

        return redirect('products')->with('status', $data['name'] . ' updated successfully');
    }
    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()->with('status', 'Product deleted');
    }
}
