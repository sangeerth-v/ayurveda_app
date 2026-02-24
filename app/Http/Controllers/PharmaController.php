<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmaCompany;

class PharmaController extends Controller
{
    public function index()
    {
        $pharmas = PharmaCompany::paginate(10);
        return view('admin.pharma.index', compact('pharmas'));
    }

    public function create()
    {
        return view('admin.pharma.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'email' => 'required|email|unique:pharma_companies',
            'password' => 'required|min:6',
            'phone' => 'required|digits:10',
            'address' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('pharmas', 'public');
        }

        PharmaCompany::create([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.pharmas.index')->with('success', 'Pharma Company added successfully');
    }

    public function show($id)
    {
        $pharma = PharmaCompany::findOrFail($id);
        return view('admin.pharma.show', compact('pharma'));
    }

    public function edit($id)
    {
        $pharma = PharmaCompany::findOrFail($id);
        return view('admin.pharma.edit', compact('pharma'));
    }

    public function update(Request $request, $id)
    {
        $pharma = PharmaCompany::findOrFail($id);

        $request->validate([
            'company_name' => 'required',
            'email' => 'required|email|unique:pharma_companies,email,' . $id,
            'password' => 'nullable|min:6',
            'phone' => 'required|digits:10',
            'address' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'company_name' => $request->company_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($pharma->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($pharma->logo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pharma->logo);
            }
            $data['logo'] = $request->file('logo')->store('pharmas', 'public');
        }

        $pharma->update($data);

        return redirect()->route('admin.pharmas.index')->with('success', 'Pharma Company updated successfully');
    }

    public function destroy($id)
    {
        $pharma = PharmaCompany::findOrFail($id);
        // Delete logo if exists
        if ($pharma->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($pharma->logo)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pharma->logo);
        }
        $pharma->delete();
        return back()->with('success', 'Pharma Company deleted successfully');
    }

    // --- Pharma Role Functions ---
    public function dashboard()
    {
        $pharmaId = \Illuminate\Support\Facades\Auth::guard('pharma')->id();
        $products = \App\Models\Product::where('pharma_company_id', $pharmaId)->get();
        
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
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
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
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
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

        if (!$order->items->isNotEmpty()) {
             abort(403);
        }

        return view('pharma.orders.show', compact('order'));
    }
}
