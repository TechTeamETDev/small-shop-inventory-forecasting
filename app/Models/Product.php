<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'buy_price', 'sell_price', 'quantity', 'low_stock_threshold'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function lowStockAlert()
    {
        return $this->hasOne(LowStockAlert::class);
    }

    public function aiPredictions()
    {
        return $this->hasMany(AiPrediction::class);
    }
}