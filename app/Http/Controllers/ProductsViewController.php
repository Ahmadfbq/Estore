<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsViewController extends Controller
{
    public function getProducts()
    {
        $products = Product::latest()->get();
        return response()->json($products);
    }
}
