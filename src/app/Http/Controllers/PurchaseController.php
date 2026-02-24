<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function showConfirmation(Product $product)
    {
        if ($product->isSold()) {
            return redirect()->route('products.show', $product);
        }

        $address = Auth::user()->profileAddress;
        return view('products.purchase', compact('product', 'address'));
    }

    public function store(Request $request, Product $product)
    {
        return redirect()->route('item.index');
    }
}
