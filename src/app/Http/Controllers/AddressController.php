<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Address;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit(Product $product)
    {
        return view('products.address', compact('product'));
    }

    public function update(AddressRequest $request, Product $product)
    {
        $newAddress = Address::create([
            'user_id' => Auth::id(),
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
            'is_profile' => false,
        ]);

        return redirect()->route('purchase.show', [
            'product' => $product->id,
            'selected_address_id' => $newAddress->id,
        ]);
    }
}
