<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    protected $fillable = ['user_id', 'product_id', 'comment'];

    // 投稿ユーザーを取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメントが紐づく商品を取得
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
