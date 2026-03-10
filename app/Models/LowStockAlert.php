<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowStockAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'alert_quantity',
        'alert_flag'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}