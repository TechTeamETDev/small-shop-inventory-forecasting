<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    // Disable automatic timestamps since we removed updated_at
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'product_id',
    'product_name',
    'quantity_sold',
    'total_price',
    'created_at', // optional, we will manually set it
    ];
  public function product()
    {
        return $this->belongsTo(Product::class);
    }
}