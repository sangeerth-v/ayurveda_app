<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorCategory;
use App\Models\DoctorSubcategory;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // --- Doctor Categories ---
    public function doctorIndex()
    {
        $categories = DoctorCategory::with('subcategories')->get();
        return view('admin.categories.doctor', compact('categories'));
    }

    public function storeDoctorCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        DoctorCategory::create(['name' => $request->name]);
        return back()->with('success', 'Doctor Category added successfully');
    }

    public function storeDoctorSubcategory(Request $request)
    {
        $request->validate([
            'doctor_category_id' => 'required|exists:doctor_categories,id',
            'name' => 'required|string|max:255'
        ]);
        DoctorSubcategory::create($request->all());
        return back()->with('success', 'Doctor Subcategory added successfully');
    }

    public function destroyDoctorCategory($id)
    {
        DoctorCategory::findOrFail($id)->delete();
        return back()->with('success', 'Doctor Category deleted successfully');
    }

    public function destroyDoctorSubcategory($id)
    {
        DoctorSubcategory::findOrFail($id)->delete();
        return back()->with('success', 'Doctor Subcategory deleted successfully');
    }

    // --- Product Categories ---
    public function productIndex()
    {
        $categories = ProductCategory::with('subcategories')->get();
        return view('admin.categories.product', compact('categories'));
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

    // --- AJAX Methods for Dynamic Dropdowns ---
    public function getDoctorSubcategories($categoryId)
    {
        return response()->json(DoctorSubcategory::where('doctor_category_id', $categoryId)->get());
    }

    public function getProductSubcategories($categoryId)
    {
        return response()->json(ProductSubcategory::where('product_category_id', $categoryId)->get());
    }
}
