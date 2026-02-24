<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PurchaseController extends Controller
{
    public function show(Request $request, Product $product)
    {
        if ($product->isSold()) {
            return redirect()->route('products.show', $product);
        }

        // 住所変更画面から戻ってきた場合
        $selectedAddressId = $request->query('selected_address_id');
        if ($selectedAddressId) {
            $address = Address::find($selectedAddressId);
        } else {
            $address = Auth::user()->profileAddress;
        }

        return view('products.purchase', compact('product', 'address'));
    }

    public function store(Request $request, Product $product)
    {
        // Stripeの秘密鍵をセット
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            if ($request->payment_method === '2') {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'payment_method_data' => [
                        'type' => 'card',
                        'card' => ['token' => $request->stripeToken],
                    ],
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                ]);
            }

            Purchase::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'address_id' => $request->address_id,
                'payment_method' => $request->payment_method,
            ]);
            $product->update(['is_sold' => true]);

            return redirect()->route('top')->with('message', '購入が完了しました！');
        } catch (\Exception $e) {
            return back()->withErrors(['stripe_error' => '決済に失敗しました：' . $e->getMessage()]);
        }
    }
}
