<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'comment' => ['required', 'max:255'],
        ]);

        Comment::create([
            'comment' => $request->comment,
            'product_id' => $product->id,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
