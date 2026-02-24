<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $keyword = $request->query('search');

        if ($tab === 'mylist') {
            // $products = Auth::check() ? Auth::user()->favoriteProducts : collect();
            $query = Auth::check() ? Auth::user()->favoriteProducts() : Product::whereRaw('1 = 0');
        } else {
            $query = Product::where('user_id', '!=', Auth::id());
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $products = $query->get();

        return view('products.index', compact('products', 'tab'));
    }

    public function show(Product $product)
    {
        $product->loadCount('comments', 'favoritedBy');
        $product->load(['condition', 'categories', 'comments.user']);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('products.sell', compact('categories', 'conditions'));
    }

    public function store(ProductRequest $request)
    {
        $user = Auth::user();

        $product = DB::transaction(function () use ($request, $user) {
            // 画像保存処理
            $imgUrl = $request->file('img_url')->store('products', 'public');

            // Productsテーブルの作成
            $newProduct = Product::create([
                'user_id' => $user->id,
                'condition_id' => $request->condition_id,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'img_url' => $imgUrl,
            ]);

            // カテゴリーの紐付け
            $newProduct->categories()->sync($request->categories);

            return $newProduct;
        });

        return redirect()->route('products.show', ['product' => $product->id]);
    }
}
