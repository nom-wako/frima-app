<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist') {
            $user = Auth::user();
            $products = ($user && method_exists($user, 'favoriteProducts')) ? $user->favoriteProducts : collect();
        } else {
            $products = Product::all();
        }
        $products = $products ?? collect();
        return view('products.index', compact('products', 'tab'));
    }

    public function show(Product $product)
    {
        $product->load(['condition', 'categories']);
        return view('products.show', compact('product'));
    }
}
