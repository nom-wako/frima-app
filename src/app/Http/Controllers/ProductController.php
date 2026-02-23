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
            $products = Auth::check() ? Auth::user()->favoriteProducts : collect();
        } else {
            $products = Product::all()->where('user_id', '!=', Auth::id());
        }
        return view('products.index', compact('products', 'tab'));
    }

    public function show(Product $product)
    {
        $product->loadCount('comments', 'favoritedBy');
        $product->load(['condition', 'categories', 'comments.user']);
        return view('products.show', compact('product'));
    }
}
