<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'buy_price', 'sell_price', 'quantity', 'low_stock_threshold'
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}