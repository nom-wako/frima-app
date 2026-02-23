<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // お気に入り登録
    public function store(Product $product)
    {
        $product->favoritedBy()->attach(auth()->id(), ['created_at' => now()]);
        return back();
    }

    // お気に入り解除
    public function destroy(Product $product)
    {
        $product->favoritedBy()->detach(auth()->id());
        return back();
    }
}
