<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condition_id',
        'name',
        'brand',
        'description',
        'price',
        'image_path',
        'is_sold'
    ];

    // 出品者を取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 商品の状態を取得
    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    // 商品カテゴリーを取得
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // 商品に紐づいたコメントを取得
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
