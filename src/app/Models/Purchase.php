<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = ['user_id', 'product_id', 'address_id', 'payment_method',];

    // 購入者を取得
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 購入商品を取得
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 送付先住所を取得
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
