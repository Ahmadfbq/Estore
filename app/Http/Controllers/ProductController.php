<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        return view('products');
    }

    public function create()
    {
        return Inertia::render('Admin/CreateProduct');
    }

    public function store(Request $request)
{
   $validatedData = $request->validate([
       'name' => 'required|string|max:255',
       'description' => 'nullable|string',
       'price' => 'required|numeric',
       'quantity' => 'required|integer',
       'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
   ]);

   if ($request->hasFile('image')) {
       $imagePath = $request->file('image')->store('images');
       $validatedData['image'] = $imagePath;
   }

   $product = Product::create($validatedData);

    
   return redirect('/products');
    }
}
