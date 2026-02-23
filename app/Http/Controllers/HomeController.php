<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Doctor;

class HomeController extends Controller
{
    public function index()
    {
        // Simple landing page data or redirect to products
        return view('home');
    }

    public function products()
    {
        // Filter: In Stock (>0) and Sort: Price Low to High
        $products = Product::where('stock', '>', 0)
                           ->orderBy('price', 'asc')
                           ->get();

        return view('products.index', compact('products'));
    }

    public function doctors()
    {
        // Fetch all doctors with their department/district
        $doctors = Doctor::with(['department', 'district'])->get();

        return view('doctors.index', compact('doctors'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
}
