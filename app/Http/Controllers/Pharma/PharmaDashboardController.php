<?php

namespace App\Http\Controllers\Pharma;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PharmaDashboardController extends Controller
{
    public function index()
    {
        $pharmaId = \Illuminate\Support\Facades\Auth::guard('pharma')->id();
        $products = \App\Models\Product::where('pharma_company_id', $pharmaId)->get();
        
        // precise fetching of orders that contain products from this pharma
        $orders = \App\Models\Order::whereHas('items.product', function ($query) use ($pharmaId) {
            $query->where('pharma_company_id', $pharmaId);
        })->with(['user', 'items' => function ($query) use ($pharmaId) {
            $query->whereHas('product', function ($q) use ($pharmaId) {
                $q->where('pharma_company_id', $pharmaId);
            })->with('product');
        }])->latest()->get();

        return view('pharma.dashboard', compact('products', 'orders'));
    }

    public function createProduct()
    {
        return view('pharma.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        \App\Models\Product::create([
            'pharma_company_id' => \Illuminate\Support\Facades\Auth::guard('pharma')->id(),
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('pharma.dashboard')->with('status', 'Product added successfully!');
    }
    public function editProduct($id)
    {
        $product = \App\Models\Product::where('pharma_company_id', \Illuminate\Support\Facades\Auth::guard('pharma')->id())
            ->findOrFail($id);
        return view('pharma.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::where('pharma_company_id', \Illuminate\Support\Facades\Auth::guard('pharma')->id())
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'category', 'description', 'price', 'stock', 'expiry_date']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('pharma.dashboard')->with('status', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = \App\Models\Product::where('pharma_company_id', \Illuminate\Support\Facades\Auth::guard('pharma')->id())
            ->findOrFail($id);
        
        $product->delete();

        return redirect()->route('pharma.dashboard')->with('status', 'Product deleted successfully!');
    }

    public function showOrder($id)
    {
        $pharmaId = \Illuminate\Support\Facades\Auth::guard('pharma')->id();
        
        $order = \App\Models\Order::with(['user', 'items' => function ($query) use ($pharmaId) {
            $query->whereHas('product', function ($q) use ($pharmaId) {
                $q->where('pharma_company_id', $pharmaId);
            })->with('product');
        }])->findOrFail($id);

        // Verify this order belongs to this pharma (has items from this pharma)
        $hasItems = $order->items->isNotEmpty();

        if (!$hasItems) {
             abort(403);
        }

        return view('pharma.orders.show', compact('order'));
    }
}
