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
        'img_url',
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

    // お気に入りでユーザーとの関連を取得
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    // 特定のユーザーがお気に入り済か判定
    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    // 購入データとの関連を取得
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
    public function isSold(): bool
    {
        return $this->purchase()->exists();
    }
}
