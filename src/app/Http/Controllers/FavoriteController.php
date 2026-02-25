<?php

namespace App\Http\Controllers;

use App\Models\Product;

class FavoriteController extends Controller
{
    public function store(Product $product)
    {
        $product->favoritedBy()->attach(auth()->id(), ['created_at' => now()]);
        return back();
    }

    public function destroy(Product $product)
    {
        $product->favoritedBy()->detach(auth()->id());
        return back();
    }
}
