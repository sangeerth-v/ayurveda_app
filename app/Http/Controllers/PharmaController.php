<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PharmaCompany;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;

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
            'password' => $request->password,
            'phone' => $request->phone,
            'address' => $request->address,
            'logo' => $logoPath,
        ]);

        return redirect()->route('admin.pharmas.index')->with('success', 'Pharma Company added successfully');
    }

    public function show($id)
    {
        $pharma = PharmaCompany::withCount('products')->findOrFail($id);
        
        $orderCount = \App\Models\Order::whereHas('items.product', function ($query) use ($id) {
            $query->where('pharma_company_id', $id);
        })->count();

        $revenue = \App\Models\OrderItem::whereHas('product', function ($query) use ($id) {
            $query->where('pharma_company_id', $id);
        })->sum(\Illuminate\Support\Facades\DB::raw('price * quantity'));

        return view('admin.pharma.show', compact('pharma', 'orderCount', 'revenue'));
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
            $data['password'] = $request->password;
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
        $categories = ProductCategory::all();
        return view('pharma.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        // Resolve Category Names
        $cat = ProductCategory::find($request->category);
        $sub = ProductSubcategory::find($request->subcategory);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        \App\Models\Product::create([
            'pharma_company_id' => \Illuminate\Support\Facades\Auth::guard('pharma')->id(),
            'name' => $request->name,
            'category' => $cat ? $cat->name : $request->category,
            'subcategory' => $sub ? $sub->name : $request->subcategory,
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
        $categories = ProductCategory::all();
        return view('pharma.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::where('pharma_company_id', \Illuminate\Support\Facades\Auth::guard('pharma')->id())
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'subcategory' => 'nullable',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        // Resolve Category Names
        $cat = ProductCategory::find($request->category);
        $sub = ProductSubcategory::find($request->subcategory);

        $data = $request->only(['name', 'description', 'price', 'stock', 'expiry_date']);
        $data['category'] = $cat ? $cat->name : $request->category;
        $data['subcategory'] = $sub ? $sub->name : $request->subcategory;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
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

    // --- Profile Management ---
    public function editProfile()
    {
        $pharma = \Illuminate\Support\Facades\Auth::guard('pharma')->user();
        return view('pharma.profile', compact('pharma'));
    }

    public function updateProfile(Request $request)
    {
        $pharma = \Illuminate\Support\Facades\Auth::guard('pharma')->user();

        $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|unique:pharma_companies,email,' . $pharma->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:6',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['company_name', 'email', 'phone', 'address']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        if ($request->hasFile('logo')) {
            if ($pharma->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($pharma->logo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($pharma->logo);
            }
            $data['logo'] = $request->file('logo')->store('pharmas', 'public');
        }

        $pharma->update($data);

        return back()->with('success', 'Profile updated successfully!');
    }

    // --- Product Category Management for Pharma ---
    public function productCategories()
    {
        $categories = ProductCategory::with('subcategories')->get();
        return view('pharma.categories.index', compact('categories'));
    }

    public function storeProductCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        ProductCategory::create(['name' => $request->name]);
        return back()->with('success', 'Product Category added successfully');
    }

    public function storeProductSubcategory(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255'
        ]);
        ProductSubcategory::create($request->all());
        return back()->with('success', 'Product Subcategory added successfully');
    }

    public function destroyProductCategory($id)
    {
        ProductCategory::findOrFail($id)->delete();
        return back()->with('success', 'Product Category deleted successfully');
    }

    public function destroyProductSubcategory($id)
    {
        ProductSubcategory::findOrFail($id)->delete();
        return back()->with('success', 'Product Subcategory deleted successfully');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:Placed,Delivered'
        ]);

        $order = \App\Models\Order::findOrFail($id);
        $order->update(['order_status' => $request->order_status]);

        return back()->with('success', 'Order status updated to ' . $request->order_status);
    }
}
