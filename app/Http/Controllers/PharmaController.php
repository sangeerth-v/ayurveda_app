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
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        PharmaCompany::create([
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password), // Hash the password
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.pharmas.index')->with('success', 'Pharma Company added successfully');
    }

    public function destroy($id)
    {
        PharmaCompany::findOrFail($id)->delete();
        return back()->with('success', 'Pharma Company deleted successfully');
    }
}
