<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
    {
        Comment::create([
            'comment' => $request->comment,
            'product_id' => $product->id,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
