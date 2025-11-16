<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $query = Product::query();

        // Filter berdasarkan search - case insensitive
        if ($search) {
            $query->where('name', 'LIKE', $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
        }

        $products = $query->paginate(12);
        
        return view('products.index', compact('products', 'search'));
    }


    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('products.show', compact('product'));
}


    
}
